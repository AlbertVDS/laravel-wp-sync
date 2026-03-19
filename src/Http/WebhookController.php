<?php

namespace Albertvds\WpSync\Http;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Albertvds\WpSync\WebhookRouter;

class WebhookController
{
    public function __invoke(Request $request): Response
    {
        $this->verifySignature($request);

        $topic   = $request->header('X-WC-Webhook-Topic');
        $payload = $request->json()->all();

        WebhookRouter::dispatch($topic, $payload);

        return response()->noContent();
    }

    protected function verifySignature(Request $request): void
    {
        $expected = base64_encode(
            hash_hmac('sha256', $request->getContent(), config('wp-sync.woo.secret'), true)
        );

        $actual = $request->header('X-WC-Webhook-Signature', '');

        if (! hash_equals($expected, $actual)) {
            abort(401, 'Invalid webhook signature.');
        }
    }
}
