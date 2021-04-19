<?php
 
namespace App\Http\Controllers;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 
class DriveController extends Controller
{
   private $drive;
   public function __construct(Google_Client $client)
   {
       $this->middleware(function ($request, $next) use ($client) {
           $accessToken = [
               'access_token' => auth()->user()->token,
               'created' => auth()->user()->created_at->timestamp,
               'expires_in' => auth()->user()->expires_in,
               'refresh_token' => auth()->user()->refresh_token
           ];
   
           $client->setAccessToken($accessToken);
   
           if ($client->isAccessTokenExpired()) {
               if ($client->getRefreshToken()) {
                   $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
               }
               auth()->user()->update([
                   'token' => $client->getAccessToken()['access_token'],
                   'expires_in' => $client->getAccessToken()['expires_in'],
                   'created_at' => $client->getAccessToken()['created'],
               ]);
           }
   
           $client->refreshToken(auth()->user()->refresh_token);
           $this->drive = new Google_Service_Drive($client);
           return $next($request);
       });
   }

   function createFolder($folder_name){
        $folder_meta = new Google_Service_Drive_DriveFile(array(
            'name' => $folder_name,
            'mimeType' => 'application/vnd.google-apps.folder'));
        $folder = $this->drive->files->create($folder_meta, array(
            'fields' => 'id'));
        return $folder->id;
    }
}