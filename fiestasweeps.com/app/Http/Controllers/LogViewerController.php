<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Carbon\Carbon;

class LogViewerController extends Controller
{
    protected $logPath;
    protected $logsPerPage = 50;

    public function __construct()
    {
        $this->logPath = storage_path('logs');
    }

    public function index(Request $request)
    {
        $logFiles = $this->getLogFiles();
        $selectedFile = $request->get('file', $this->getLatestLogFile());
        $level = $request->get('level', 'all');
        $search = $request->get('search', '');
        $page = $request->get('page', 1);

        if (!$selectedFile || !in_array($selectedFile, $logFiles)) {
            $selectedFile = $this->getLatestLogFile();
        }

        $logData = $this->parseLogFile($selectedFile, $level, $search, $page);

        return view('admin.logs', compact(
            'logFiles',
            'selectedFile',
            'logData',
            'level',
            'search',
            'page'
        ));
    }

    public function download(Request $request)
    {
        $fileName = $request->get('file');
        $filePath = $this->logPath . '/' . $fileName;

        if (!File::exists($filePath) || !$this->isValidLogFile($fileName)) {
            abort(404, 'Log file not found');
        }

        return Response::download($filePath);
    }

    public function delete(Request $request)
    {
        $fileName = $request->get('file');
        $filePath = $this->logPath . '/' . $fileName;

        if (!File::exists($filePath) || !$this->isValidLogFile($fileName)) {
            return response()->json(['error' => 'Log file not found'], 404);
        }

        if (File::delete($filePath)) {
            return response()->json(['success' => 'Log file deleted successfully']);
        }

        return response()->json(['error' => 'Failed to delete log file'], 500);
    }

    public function clear()
    {
        $logFiles = $this->getLogFiles();
        $deletedCount = 0;

        foreach ($logFiles as $file) {
            $filePath = $this->logPath . '/' . $file;
            if (File::delete($filePath)) {
                $deletedCount++;
            }
        }

        return response()->json([
            'success' => "Deleted {$deletedCount} log files successfully"
        ]);
    }

    protected function getLogFiles(): array
    {
        if (!File::exists($this->logPath)) {
            return [];
        }

        $files = File::files($this->logPath);
        $logFiles = [];

        foreach ($files as $file) {
            $fileName = $file->getFilename();
            if ($this->isValidLogFile($fileName)) {
                $logFiles[] = $fileName;
            }
        }

        usort($logFiles, function($a, $b) {
            $timeA = File::lastModified($this->logPath . '/' . $a);
            $timeB = File::lastModified($this->logPath . '/' . $b);
            return $timeB - $timeA;
        });

        return $logFiles;
    }

    protected function getLatestLogFile(): ?string
    {
        $files = $this->getLogFiles();
        return $files[0] ?? null;
    }

    protected function isValidLogFile(string $fileName): bool
    {
        return Str::endsWith($fileName, '.log') &&
               !Str::contains($fileName, ['..', '/', '\\']);
    }

    protected function parseLogFile(string $fileName, string $level = 'all', string $search = '', int $page = 1): array
    {
        $filePath = $this->logPath . '/' . $fileName;

        if (!File::exists($filePath)) {
            return [
                'logs' => [],
                'total' => 0,
                'pages' => 0,
                'currentPage' => 1,
                'fileSize' => 0,
                'lastModified' => null
            ];
        }

        $fileSize = File::size($filePath);
        $lastModified = Carbon::createFromTimestamp(File::lastModified($filePath));

        $content = File::get($filePath);
        $logEntries = $this->parseLogEntries($content);

        if ($level !== 'all') {
            $logEntries = array_filter($logEntries, function($entry) use ($level) {
                return strtolower($entry['level']) === strtolower($level);
            });
        }

        if (!empty($search)) {
            $logEntries = array_filter($logEntries, function($entry) use ($search) {
                return Str::contains(strtolower($entry['message']), strtolower($search)) ||
                       Str::contains(strtolower($entry['context']), strtolower($search));
            });
        }

        $logEntries = array_reverse(array_values($logEntries));

        $total = count($logEntries);
        $pages = ceil($total / $this->logsPerPage);
        $offset = ($page - 1) * $this->logsPerPage;
        $paginatedLogs = array_slice($logEntries, $offset, $this->logsPerPage);

        return [
            'logs' => $paginatedLogs,
            'total' => $total,
            'pages' => $pages,
            'currentPage' => $page,
            'fileSize' => $this->formatBytes($fileSize),
            'lastModified' => $lastModified
        ];
    }

    protected function parseLogEntries(string $content): array
    {
        $pattern = '/\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\] (\w+)\.(\w+): (.*?)(?=\[\d{4}-\d{2}-\d{2}|\Z)/s';
        preg_match_all($pattern, $content, $matches, PREG_SET_ORDER);

        $logEntries = [];

        foreach ($matches as $match) {
            $timestamp = $match[1] ?? '';
            $environment = $match[2] ?? '';
            $level = $match[3] ?? '';
            $fullMessage = $match[4] ?? '';

            $parts = explode(' {', $fullMessage, 2);
            $message = trim($parts[0]);
            $context = isset($parts[1]) ? '{' . $parts[1] : '';

            $logEntries[] = [
                'timestamp' => $timestamp,
                'environment' => $environment,
                'level' => $level,
                'message' => $message,
                'context' => $context,
                'full_message' => $fullMessage
            ];
        }

        return $logEntries;
    }

    protected function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
