<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use App\Traits\ResponseAPI;

class WhatsappClientMiddleware
{
    use ResponseAPI;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $clientToken = $request->header('client_token'); // Get the client token from the request header
        $clientId = $request->header('client_id'); // Get the client ID from the request header

        // Validate both client token and client ID in a single query
        $isValid = User::join('whatsapp_clients', 'users.id', '=', 'whatsapp_clients.user_id')
            ->where('users.token', $clientToken)
            ->where('whatsapp_clients.client_id', $clientId)
            ->exists();

        if (!$isValid) {
            return $this->error('Unauthorized: Invalid client token or client ID');
        }
        return $next($request);
    }
}
