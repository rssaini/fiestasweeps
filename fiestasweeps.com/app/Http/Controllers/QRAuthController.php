<?php

namespace App\Http\Controllers;

use App\Models\AuthToken;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Auth;

class QRAuthController extends Controller
{
    public function generateQR(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $page = $request->page;

        // Generate token for current user
        $authToken = AuthToken::generateForUser(Auth::id());

        // Create the URL that mobile will call
        $loginUrl = route('qr.login', ['token' => $authToken->token, 'redirect' => $page]);

        // Generate QR code
        $qrCode = QrCode::size(200)->generate($loginUrl);

        return response()->json([
            'qr_code' => base64_encode($qrCode),
            'token' => $authToken->token,
            'expires_at' => $authToken->expires_at->toISOString()
        ]);
    }

    public function loginWithQR(Request $request, $token)
    {
        // Find and validate token
        $authToken = AuthToken::where('token', $token)->first();

        if (!$authToken || !$authToken->isValid()) {
            return response()->json(['error' => 'Invalid or expired token'], 400);
        }

        // Mark token as used
        $authToken->markAsUsed();

        // Log in the user
        Auth::login($authToken->user);

        if($request->has('redirect')){
            return redirect(urldecode($request->redirect))->with('success', 'Successfully logged in via QR code!');
        }

        // Optionally, redirect to a specific page
        return redirect()->route('dashboard.identity.verification')->with('success', 'Successfully logged in via QR code!');
    }

    public function checkQRStatus(Request $request, $token)
    {
        $authToken = AuthToken::where('token', $token)->first();

        if (!$authToken) {
            return response()->json(['status' => 'invalid']);
        }

        if ($authToken->used) {
            return response()->json(['status' => 'used']);
        }
        if (!$authToken->isValid()) {
            return response()->json(['status' => 'expired']);
        }



        return response()->json(['status' => 'pending']);
    }
}
