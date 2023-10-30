<?php

namespace syahrulzzadie\SatuSehat\JsonResponse;

class Error
{
    public static function response($response)
    {
        if ($response->status() == 200) {
            $data = json_decode($response->body(),true);
            $message = $data['issue'][0]['details']['text'];
            return [
                'status' => 'false',
                'message' => $message
            ];
        } else if ($response->status() == 400) {
            $data = json_decode($response->body(),true);
            $code = $data['issue'][0]['code'];
            $text = $data['issue'][0]['details']['text'];
            if ($code == 'structure' && $text == 'resource_mismatch') {
                $message = $data['issue'][0]['diagnostics'];
                return [
                    'status' => 'false',
                    'message' => $message
                ];
            } else if($code == 'structure' && $text == 'unparseable_resource') {
                $message = $data['issue'][0]['diagnostics'];
                return [
                    'status' => 'false',
                    'message' => $message
                ];
            } else if($code == 'forbidden') {
                return [
                    'status' => 'false',
                    'message' => $text
                ];
            } else {
                return [
                    'status' => 'false',
                    'message' => 'Code: 400 Unknown error'
                ];
            }
        } else if ($response->status() == 401) {
            $data = json_decode($response->body(),true);
            $errorCode = $data['fault']['detail']['errorcode'];
            if ($errorCode == 'keymanagement.service.InvalidAPICallAsNoApiProductMatchFound') {
                $message = $data['fault']['faultstring'];
                return [
                    'status' => 'false',
                    'message' => $message
                ];
            } else if ($errorCode == 'oauth.v2.InvalidAccessToken') {
                $message = $data['fault']['faultstring'];
                return [
                    'status' => 'false',
                    'message' => $message
                ];
            } else {
                return [
                    'status' => 'false',
                    'message' => 'ClientId is Invalid'
                ];
            }
        } else if ($response->status() == 403) {
            return [
                'status' => 'false',
                'message' => '403 Forbidden'
            ];
        } else if ($response->status() == 404) {
            return [
                'status' => 'false',
                'message' => 'Wrong URL'
            ];
        } else {
            return [
                'status' => 'false',
                'message' => 'API Error'
            ];
        }
    }
}