<?php

namespace App\Request;

/**
 * Class PostRequest
 *
 * @package App
 */
class PostRequest extends AbstractRequest
{
    /**
     * @return array
     */
    final public function send(): array
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->params);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [self::USER_AGENT_HEADER]);
        $output = curl_exec($ch);
        curl_close($ch);

        return json_decode($output, true) ?? [];
    }
}