<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Log Viewer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    :root {
        --bg-primary: #ffffff;
        --bg-secondary: #f8f9fa;
        --text-primary: #2d3748;
        --text-secondary: #718096;
        --border-color: #e2e8f0;
        --shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
    }

    [data-theme="dark"] {
        --bg-primary: #1a202c;
        --bg-secondary: #2d3748;
        --text-primary: #f7fafc;
        --text-secondary: #cbd5e0;
        --border-color: #4a5568;
        --shadow: 0 1px 3px rgba(0,0,0,0.3), 0 1px 2px rgba(0,0,0,0.5);
    }

    body {
        background-color: var(--bg-secondary);
        color: var(--text-primary);
        transition: all 0.3s ease;
    }

    .log-viewer-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }

    .log-header {
        background: var(--bg-primary);
        padding: 24px;
        border-radius: 12px;
        box-shadow: var(--shadow);
        margin-bottom: 24px;
        border: 1px solid var(--border-color);
    }

    .log-controls {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-control {
        padding: 12px 16px;
        border: 2px solid var(--border-color);
        border-radius: 8px;
        background: var(--bg-primary);
        color: var(--text-primary);
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #3182ce;
        box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1);
    }

    .btn {
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        justify-content: center;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    .btn-danger {
        background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
        color: white;
    }

    .btn-success {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        color: white;
    }

    .btn-secondary {
        background: var(--bg-secondary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
    }

    .log-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 16px;
        margin-bottom: 20px;
    }

    .stat-card {
        background: var(--bg-primary);
        padding: 16px;
        border-radius: 8px;
        text-align: center;
        border: 1px solid var(--border-color);
    }

    .stat-number {
        font-size: 24px;
        font-weight: 700;
        color: var(--text-primary);
    }

    .stat-label {
        font-size: 12px;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .log-content {
        background: var(--bg-primary);
        border-radius: 12px;
        box-shadow: var(--shadow);
        border: 1px solid var(--border-color);
        overflow: hidden;
    }

    .log-entry {
        padding: 16px 20px;
        border-bottom: 1px solid var(--border-color);
        transition: background-color 0.2s ease;
        cursor: pointer;
    }

    .log-entry:hover {
        background: var(--bg-secondary);
    }

    .log-entry:last-child {
        border-bottom: none;
    }

    .log-header-row {
        display: grid;
        grid-template-columns: 140px 80px 1fr auto;
        gap: 16px;
        align-items: center;
        margin-bottom: 8px;
    }

    .log-timestamp {
        font-family: 'Monaco', 'Menlo', monospace;
        font-size: 12px;
        color: var(--text-secondary);
        background: var(--bg-secondary);
        padding: 4px 8px;
        border-radius: 4px;
    }

    .log-level {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-align: center;
    }

    .log-level.emergency { background: #742a2a; color: #fed7d7; }
    .log-level.alert { background: #9c2a00; color: #fed7cc; }
    .log-level.critical { background: #c53030; color: #fed7d7; }
    .log-level.error { background: #e53e3e; color: #fff; }
    .log-level.warning { background: #d69e2e; color: #fff; }
    .log-level.notice { background: #3182ce; color: #fff; }
    .log-level.info { background: #38a169; color: #fff; }
    .log-level.debug { background: #718096; color: #fff; }

    .log-message {
        font-family: 'Monaco', 'Menlo', monospace;
        font-size: 13px;
        line-height: 1.5;
        color: var(--text-primary);
        word-break: break-word;
    }

    .log-context {
        margin-top: 8px;
        padding: 12px;
        background: var(--bg-secondary);
        border-radius: 6px;
        font-family: 'Monaco', 'Menlo', monospace;
        font-size: 11px;
        color: var(--text-secondary);
        overflow-x: auto;
        white-space: pre-wrap;
        max-height: 200px;
        overflow-y: auto;
    }

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        padding: 20px;
        background: var(--bg-primary);
        border-top: 1px solid var(--border-color);
    }

    .page-btn {
        padding: 8px 12px;
        border: 1px solid var(--border-color);
        background: var(--bg-primary);
        color: var(--text-primary);
        border-radius: 6px;
        text-decoration: none;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .page-btn:hover {
        background: var(--bg-secondary);
        border-color: #3182ce;
    }

    .page-btn.active {
        background: #3182ce;
        color: white;
        border-color: #3182ce;
    }

    .page-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: var(--text-secondary);
    }

    .empty-icon {
        font-size: 48px;
        margin-bottom: 16px;
        opacity: 0.5;
    }

    .theme-toggle {
        position: fixed;
        top: 20px;
        right: 20px;
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 50%;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: var(--shadow);
        z-index: 1000;
        transition: all 0.2s ease;
    }

    .theme-toggle:hover {
        transform: scale(1.1);
    }

    .loading {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
        font-size: 16px;
        color: var(--text-secondary);
    }

    .spinner {
        width: 20px;
        height: 20px;
        border: 2px solid var(--border-color);
        border-top: 2px solid #3182ce;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-right: 12px;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .file-info {
        display: flex;
        align-items: center;
        gap: 16px;
        font-size: 12px;
        color: var(--text-secondary);
    }

    .file-info-item {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .auto-refresh {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 40px;
        height: 20px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 20px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        left: 2px;
        bottom: 2px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background-color: #3182ce;
    }

    input:checked + .slider:before {
        transform: translateX(20px);
    }

    @media (max-width: 768px) {
        .log-header-row {
            grid-template-columns: 1fr;
            gap: 8px;
            text-align: left;
        }

        .log-controls {
            grid-template-columns: 1fr;
        }

        .log-stats {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a>
            <div class="navbar-nav ms-auto">
                @auth
                    <a class="nav-link" href="{{ route('logs.index') }}">📊 Logs</a>
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                @endauth
            </div>
        </div>
    </nav>
    <main>
        <div class="log-viewer-container">
    {{-- Theme Toggle --}}
    <div class="theme-toggle" onclick="toggleTheme()">
        <span id="theme-icon">🌙</span>
    </div>

    {{-- Header --}}
    <div class="log-header">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h3 mb-0">🔍 Laravel Log Viewer</h1>
            <div class="auto-refresh">
                <label class="switch">
                    <input type="checkbox" id="autoRefresh">
                    <span class="slider"></span>
                </label>
                <span>Auto Refresh</span>
            </div>
        </div>

        {{-- Controls --}}
        <form method="GET" id="logForm" class="log-controls">
            <div class="form-group">
                <label for="file">📁 Log File</label>
                <select name="file" id="file" class="form-control" onchange="document.getElementById('logForm').submit()">
                    <option value="">Select a log file...</option>
                    @foreach($logFiles as $file)
                        <option value="{{ $file }}" {{ $selectedFile === $file ? 'selected' : '' }}>
                            {{ $file }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="level">🎯 Log Level</label>
                <select name="level" id="level" class="form-control" onchange="document.getElementById('logForm').submit()">
                    <option value="all" {{ $level === 'all' ? 'selected' : '' }}>All Levels</option>
                    <option value="emergency" {{ $level === 'emergency' ? 'selected' : '' }}>Emergency</option>
                    <option value="alert" {{ $level === 'alert' ? 'selected' : '' }}>Alert</option>
                    <option value="critical" {{ $level === 'critical' ? 'selected' : '' }}>Critical</option>
                    <option value="error" {{ $level === 'error' ? 'selected' : '' }}>Error</option>
                    <option value="warning" {{ $level === 'warning' ? 'selected' : '' }}>Warning</option>
                    <option value="notice" {{ $level === 'notice' ? 'selected' : '' }}>Notice</option>
                    <option value="info" {{ $level === 'info' ? 'selected' : '' }}>Info</option>
                    <option value="debug" {{ $level === 'debug' ? 'selected' : '' }}>Debug</option>
                </select>
            </div>

            <div class="form-group">
                <label for="search">🔍 Search</label>
                <input type="text" name="search" id="search" class="form-control"
                       value="{{ $search }}" placeholder="Search in logs...">
            </div>

            <div class="form-group">
                <label>&nbsp;</label>
                <div style="display: flex; gap: 8px;">
                    <button type="submit" class="btn btn-primary">
                        🔍 Filter
                    </button>
                    <a href="{{ route('logs.index') }}" class="btn btn-secondary">
                        🔄 Reset
                    </a>
                </div>
            </div>

            <input type="hidden" name="page" value="1">
        </form>

        {{-- File Actions --}}
        @if($selectedFile)
        <div style="display: flex; gap: 12px; flex-wrap: wrap; margin-top: 16px;">
            <a href="{{ route('logs.download', ['file' => $selectedFile]) }}" class="btn btn-success btn-sm">
                📥 Download
            </a>
            <button onclick="deleteLogFile('{{ $selectedFile }}')" class="btn btn-danger btn-sm">
                🗑️ Delete File
            </button>
            <button onclick="clearAllLogs()" class="btn btn-danger btn-sm">
                🧹 Clear All Logs
            </button>
        </div>
        @endif

        {{-- File Info --}}
        @if($selectedFile && isset($logData['fileSize']))
        <div class="file-info" style="margin-top: 16px;">
            <div class="file-info-item">
                <span>📊</span>
                <span>Size: {{ $logData['fileSize'] }}</span>
            </div>
            <div class="file-info-item">
                <span>📅</span>
                <span>Modified: {{ $logData['lastModified']->diffForHumans() }}</span>
            </div>
            <div class="file-info-item">
                <span>📝</span>
                <span>Total Entries: {{ number_format($logData['total']) }}</span>
            </div>
        </div>
        @endif
    </div>

    {{-- Statistics --}}
    @if($selectedFile && $logData['total'] > 0)
    <div class="log-stats">
        <div class="stat-card">
            <div class="stat-number">{{ number_format($logData['total']) }}</div>
            <div class="stat-label">Total Entries</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $logData['pages'] }}</div>
            <div class="stat-label">Pages</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $logData['currentPage'] }}</div>
            <div class="stat-label">Current Page</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ count($logData['logs']) }}</div>
            <div class="stat-label">Showing</div>
        </div>
    </div>
    @endif

    {{-- Log Content --}}
    <div class="log-content">
        @if($selectedFile && count($logData['logs']) > 0)
            @foreach($logData['logs'] as $index => $log)
            <div class="log-entry" onclick="toggleLogDetails({{ $index }})">
                <div class="log-header-row">
                    <div class="log-timestamp">{{ $log['timestamp'] }}</div>
                    <div class="log-level {{ strtolower($log['level']) }}">{{ $log['level'] }}</div>
                    <div class="log-message">{{ Str::limit($log['message'], 150) }}</div>
                    <div>
                        @if(!empty($log['context']))
                            <span style="font-size: 12px; color: var(--text-secondary);">📋 Context</span>
                        @endif
                    </div>
                </div>

                @if(!empty($log['context']))
                <div id="context-{{ $index }}" class="log-context" style="display: none;">
                    {{ $log['context'] }}
                </div>
                @endif
            </div>
            @endforeach

            {{-- Pagination --}}
            @if($logData['pages'] > 1)
            <div class="pagination">
                @if($logData['currentPage'] > 1)
                    <a href="{{ request()->fullUrlWithQuery(['page' => $logData['currentPage'] - 1]) }}"
                       class="page-btn">‹ Previous</a>
                @endif

                @for($i = max(1, $logData['currentPage'] - 2); $i <= min($logData['pages'], $logData['currentPage'] + 2); $i++)
                    <a href="{{ request()->fullUrlWithQuery(['page' => $i]) }}"
                       class="page-btn {{ $i == $logData['currentPage'] ? 'active' : '' }}">{{ $i }}</a>
                @endfor

                @if($logData['currentPage'] < $logData['pages'])
                    <a href="{{ request()->fullUrlWithQuery(['page' => $logData['currentPage'] + 1]) }}"
                       class="page-btn">Next ›</a>
                @endif
            </div>
            @endif

        @elseif($selectedFile)
            <div class="empty-state">
                <div class="empty-icon">📝</div>
                <h3>No Log Entries Found</h3>
                <p>No entries match your current filters or the log file is empty.</p>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">📁</div>
                <h3>No Log File Selected</h3>
                <p>Please select a log file from the dropdown above to view its contents.</p>
            </div>
        @endif
    </div>
</div>

{{-- Loading Overlay --}}
<div id="loadingOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999;">
    <div class="loading" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: var(--bg-primary); padding: 40px; border-radius: 12px;">
        <div class="spinner"></div>
        Processing...
    </div>
</div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
// Theme Management
function toggleTheme() {
    const currentTheme = document.documentElement.getAttribute('data-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

    document.documentElement.setAttribute('data-theme', newTheme);
    document.getElementById('theme-icon').textContent = newTheme === 'dark' ? '☀️' : '🌙';

    localStorage.setItem('theme', newTheme);
}

// Initialize theme
document.addEventListener('DOMContentLoaded', function() {
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);
    document.getElementById('theme-icon').textContent = savedTheme === 'dark' ? '☀️' : '🌙';
});

// Toggle log details
function toggleLogDetails(index) {
    const context = document.getElementById('context-' + index);
    if (context) {
        context.style.display = context.style.display === 'none' ? 'block' : 'none';
    }
}

// Delete log file
function deleteLogFile(fileName) {
    if (!confirm('Are you sure you want to delete this log file? This action cannot be undone.')) {
        return;
    }

    showLoading();

    fetch('{{ route("logs.delete") }}?file=' + encodeURIComponent(fileName), {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        hideLoading();
        if (data.success) {
            alert('Log file deleted successfully!');
            window.location.reload();
        } else {
            alert('Error: ' + data.error);
        }
    })
    .catch(error => {
        hideLoading();
        alert('Error deleting file: ' + error.message);
    });
}

// Clear all logs
function clearAllLogs() {
    if (!confirm('Are you sure you want to delete ALL log files? This action cannot be undone.')) {
        return;
    }

    showLoading();

    fetch('{{ route("logs.clear") }}', {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        hideLoading();
        if (data.success) {
            alert(data.success);
            window.location.reload();
        } else {
            alert('Error: ' + data.error);
        }
    })
    .catch(error => {
        hideLoading();
        alert('Error clearing logs: ' + error.message);
    });
}

// Auto refresh functionality
let autoRefreshInterval;

document.getElementById('autoRefresh').addEventListener('change', function() {
    if (this.checked) {
        autoRefreshInterval = setInterval(() => {
            window.location.reload();
        }, 30000); // Refresh every 30 seconds
    } else {
        clearInterval(autoRefreshInterval);
    }
});

// Loading overlay
function showLoading() {
    document.getElementById('loadingOverlay').style.display = 'block';
}

function hideLoading() {
    document.getElementById('loadingOverlay').style.display = 'none';
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + R for refresh
    if ((e.ctrlKey || e.metaKey) && e.key === 'r') {
        e.preventDefault();
        window.location.reload();
    }

    // Ctrl/Cmd + F for search
    if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
        e.preventDefault();
        document.getElementById('search').focus();
    }

    // Escape to clear search
    if (e.key === 'Escape') {
        document.getElementById('search').value = '';
    }
});

// Auto-submit search on Enter
document.getElementById('search').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        document.getElementById('logForm').submit();
    }
});

console.log('🔍 Log Viewer loaded successfully!');
</script>
</body>
</html>
