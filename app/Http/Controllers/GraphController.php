<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Jumbojett\OpenIDConnectClient;
use GuzzleHttp\Client;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

class GraphController extends Controller
{
    public $accesstoken;

    public function __construct()
    {
        $client = new Client();
        $tenantId = '3ddf666d-6bc6-4456-aa5f-c2c8b750996b';
        $url = 'https://login.microsoftonline.com/' . $tenantId . '/oauth2/token?api-version=1.0';
        $token = json_decode($client->post($url, [
            'form_params' => [
                'client_id' => '8d322177-521b-4245-bb56-52e52912481d',///$clientId,
                'client_secret' => 'n10H361uVyn3wJu--.QY7dB_46s.XEq_LC', // $clientSecret,
                'resource' => 'https://graph.microsoft.com/',
                'grant_type' => 'client_credentials',
            ],
        ])->getBody()->getContents());
        $this->accessToken = $token->access_token;
    }
    public function profile()
    {
        $accessToken = 'eyJ0eXAiOiJKV1QiLCJub25jZSI6IjhFSmhDbmIyMmp4MGJ1S1JZN3lZMGRWWkJCNzNoenQ2Nko3OTZvNDlmaG8iLCJhbGciOiJSUzI1NiIsIng1dCI6Im5PbzNaRHJPRFhFSzFqS1doWHNsSFJfS1hFZyIsImtpZCI6Im5PbzNaRHJPRFhFSzFqS1doWHNsSFJfS1hFZyJ9.eyJhdWQiOiJodHRwczovL2dyYXBoLm1pY3Jvc29mdC5jb20iLCJpc3MiOiJodHRwczovL3N0cy53aW5kb3dzLm5ldC8zZGRmNjY2ZC02YmM2LTQ0NTYtYWE1Zi1jMmM4Yjc1MDk5NmIvIiwiaWF0IjoxNjIwMjk4MzIzLCJuYmYiOjE2MjAyOTgzMjMsImV4cCI6MTYyMDMwMjIyMywiYWNjdCI6MCwiYWNyIjoiMSIsImFjcnMiOlsidXJuOnVzZXI6cmVnaXN0ZXJzZWN1cml0eWluZm8iLCJ1cm46bWljcm9zb2Z0OnJlcTEiLCJ1cm46bWljcm9zb2Z0OnJlcTIiLCJ1cm46bWljcm9zb2Z0OnJlcTMiLCJjMSIsImMyIiwiYzMiLCJjNCIsImM1IiwiYzYiLCJjNyIsImM4IiwiYzkiLCJjMTAiLCJjMTEiLCJjMTIiLCJjMTMiLCJjMTQiLCJjMTUiLCJjMTYiLCJjMTciLCJjMTgiLCJjMTkiLCJjMjAiLCJjMjEiLCJjMjIiLCJjMjMiLCJjMjQiLCJjMjUiXSwiYWlvIjoiQVNRQTIvOFRBQUFBOEppYlJHUlpRZnRQbXpBVHprSUN3Y1lQc3Q2SDZoT1dsM1FJTWJzcG5nTT0iLCJhbXIiOlsicHdkIl0sImFwcF9kaXNwbGF5bmFtZSI6IkdyYXBoIEFQSSBEZW1vIiwiYXBwaWQiOiI4ZDMyMjE3Ny01MjFiLTQyNDUtYmI1Ni01MmU1MjkxMjQ4MWQiLCJhcHBpZGFjciI6IjEiLCJmYW1pbHlfbmFtZSI6IkRhcyIsImdpdmVuX25hbWUiOiJBYmlyIiwiaWR0eXAiOiJ1c2VyIiwiaXBhZGRyIjoiMTE2LjU4LjIwMy43MiIsIm5hbWUiOiJBYmlyIERhcyIsIm9pZCI6IjVkMjNiOTEwLWM5YjktNDM3Yi04ZGEyLTliZTZiNTc2MDE3YyIsInBsYXRmIjoiMyIsInB1aWQiOiIxMDAzMjAwMTNDQUY3OTE2IiwicmgiOiIwLkFYQUFiV2JmUGNaclZrU3FYOExJdDFDWmEzY2hNbzBiVWtWQ3UxWlM1U2tTU0Ixd0FFQS4iLCJzY3AiOiJDaGFubmVsLkNyZWF0ZSBDaGFubmVsLlJlYWRCYXNpYy5BbGwgVGVhbS5DcmVhdGUgVGVhbS5SZWFkQmFzaWMuQWxsIFVzZXIuUmVhZCBVc2VyLlJlYWQuQWxsIFVzZXIuUmVhZEJhc2ljLkFsbCBwcm9maWxlIG9wZW5pZCBlbWFpbCIsInNpZ25pbl9zdGF0ZSI6WyJrbXNpIl0sInN1YiI6IkpGOGtlZi0za2JTeGhULXV1MmNEX2I0RmNiVVJKdmpOekdKS2ItUGVURWMiLCJ0ZW5hbnRfcmVnaW9uX3Njb3BlIjoiQVMiLCJ0aWQiOiIzZGRmNjY2ZC02YmM2LTQ0NTYtYWE1Zi1jMmM4Yjc1MDk5NmIiLCJ1bmlxdWVfbmFtZSI6ImFiaXJAZGFzMjgub25taWNyb3NvZnQuY29tIiwidXBuIjoiYWJpckBkYXMyOC5vbm1pY3Jvc29mdC5jb20iLCJ1dGkiOiJJYmNoNF9QczRVbXdFazc2WFJrcEF3IiwidmVyIjoiMS4wIiwid2lkcyI6WyI2MmU5MDM5NC02OWY1LTQyMzctOTE5MC0wMTIxNzcxNDVlMTAiLCJiNzlmYmY0ZC0zZWY5LTQ2ODktODE0My03NmIxOTRlODU1MDkiXSwieG1zX3N0Ijp7InN1YiI6Ii1lUkJJaFplcjBrNm9lSW9lNEdudnotOGNGU1RiREs1eGZicEphM0M4QTgifSwieG1zX3RjZHQiOjE2MjAyODczMzR9.nytvm809PygERtGQqkSwp5YiSghaQDRgnJqL7flZM4caM1b2vA0hc5guU07b-Xz4p8YQII0bC_MgfPzOwSyAsKBwhfmpLusWChxrMeezfFSh8Mool4G-cLv5_Ide1NmW2P5i3iH9GkQHQy78UoLJ7Dvzr1xvaDUMqPNPiAK_hcFfesAeCIP8o8-UvN6bn7fOtbD1tlCrr0WKcSIg1xP7dK6FNws9jCW4TNHmH7C0-kRx9w0_f29etI59ZrDiVV9kFygR4N9-AXQDCQPNXLeiUMRPdnGp78D44Qv9TAYJOzZnqpGc5DXIw4ZaL5ECvQmM4YMIOuCMXdYr0xetk35Blg';
        $graph = new Graph();
        $graph->setAccessToken($this->accessToken);

        $user = $graph->createRequest("GET", "/me")
            ->setReturnType(Model\User::class)
            ->execute();
        return $user;

    }
    public function teamCreate()
    {
        return view('team.create');
    }
    public function teamCreatePost(Request $request)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://graph.microsoft.com/v1.0/teams',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                  "template@odata.bind": "https://graph.microsoft.com/v1.0/teamsTemplates(\'standard\')",
                  "displayName": "'.$request->team_name.'",
                  "description": "My Sample Team’s Description"
             }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer '.$this->accessToken.''
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        echo $response;
    }
}
