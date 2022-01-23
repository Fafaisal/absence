<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Absence;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use DB;
use Carbon\Carbon;

class AbsenceController extends Controller
{
    public function absenceIn(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userid' => 'required|string|min:5|max:20',
            'absence_in' => 'required|date_format:Y-m-d H:i:s',
            'ip_address'    => 'required|max:20',
            'img_selfie'    => 'required|base64_image'
        ]);
 
        if($validator->fails()){
            $data = array(
                "errorCode"         => "400",
                "errorDescription"  => "Fail to Absence",
                "errorMessage"      => $validator->messages()
            );
            return response()->json($data, 400);
        }

        $currentUserInfo = Location::get($request->get('ip_address'));

        if($currentUserInfo == false){
            $data = array(
                "errorCode"         => "400",
                "errorDescription"  => "Fail to read IP",
                "errorMessage"      => $validator->messages()
            );
            return response()->json($data, 400);
        }
        
        $image = $request->get('img_selfie');  // your base64 encoded
        $decoded_file = base64_decode($image); // decode the file
        $mime_type = finfo_buffer(finfo_open(), $decoded_file, FILEINFO_MIME_TYPE); // extract mime type
        $extension = $this->mime2ext($mime_type); // extract extension from mime type
        $image = str_replace('data:image/'.$extension.';base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $filename = str::random(10).'.'.$extension;
        $filePath = 'selfie/'.$filename;

        $disk = Storage::disk('local')->put($filePath, base64_decode($image));

        $insertAbsence = DB::select(
            'call SpAbsenceEmployee (?,?,?,?,?,?,?,?,?,?,?,?)',
            array(
                null,
                $request->get('userid'),
                $filePath,
                $request->get('absence_in'),
                null,
                $request->get('ip_address'),
                $currentUserInfo->cityName,
                $currentUserInfo->regionName,
                $currentUserInfo->countryCode,
                $currentUserInfo->countryName,
                $currentUserInfo->latitude,
                $currentUserInfo->longitude
            )
        );

        if(count($insertAbsence) > 0):
            $data = array(
                "errorCode"         => "200",
                "errorDescription"  => "Successfully Registered Absence In",
                "errorMessage"      => $validator->messages()
            );
     
            return response()->json($data,200);
        else:
            $data = array(
                "errorCode"         => "400",
                "errorDescription"  => "Failed Registered Absence In",
                "errorMessage"      => $validator->messages()
            );
     
            return response()->json($data,400);
        endif;
    }

    public function absenceOut(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'absenceid' => 'required|numeric',
            'absence_out' => 'required|date_format:Y-m-d H:i:s',
            'ip_address'    => 'required|max:20',
            'img_selfie'    => 'required|base64_image'
        ]);
 
        if($validator->fails()){
            $data = array(
                "errorCode"         => "400",
                "errorDescription"  => "Fail to Absence",
                "errorMessage"      => $validator->messages()
            );
            return response()->json($data, 400);
        }

        $currentUserInfo = Location::get($request->get('ip_address'));

        if($currentUserInfo == false){
            $data = array(
                "errorCode"         => "400",
                "errorDescription"  => "Fail to read IP",
                "errorMessage"      => $validator->messages()
            );
            return response()->json($data, 400);
        }
        
        $image = $request->get('img_selfie');  // your base64 encoded
        $decoded_file = base64_decode($image); // decode the file
        $mime_type = finfo_buffer(finfo_open(), $decoded_file, FILEINFO_MIME_TYPE); // extract mime type
        $extension = $this->mime2ext($mime_type); // extract extension from mime type
        $image = str_replace('data:image/'.$extension.';base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $filename = str::random(10).'.'.$extension;
        $filePath = 'selfie/'.$filename;

        $disk = Storage::disk('local')->put($filePath, base64_decode($image));

        $id = (int)$request->get('absenceid');

       // DB::enableQueryLog(); // Enable query log

        $insertAbsence = DB::select(
            'call SpAbsenceEmployee (?,?,?,?,?,?,?,?,?,?,?,?)',
            array(
                $id,
                null,
                $filePath,
                null,
                $request->get('absence_out'),
                $request->get('ip_address'),
                $currentUserInfo->cityName,
                $currentUserInfo->regionName,
                $currentUserInfo->countryCode,
                $currentUserInfo->countryName,
                $currentUserInfo->latitude,
                $currentUserInfo->longitude
            )
        );

        //dd(DB::getQueryLog()); // Show results of log

        if(count($insertAbsence) > 0):
            $data = array(
                "errorCode"         => "200",
                "errorDescription"  => "Successfully Registered Absence Out",
                "errorMessage"      => $validator->messages()
            );
     
            return response()->json($data,200);
        else:
            $data = array(
                "errorCode"         => "400",
                "errorDescription"  => "Failed Registered Absence Out",
                "errorMessage"      => $validator->messages()
            );
     
            return response()->json($data,400);
        endif;
    }

    public function getAbsenceById(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
        ]);
 
        if($validator->fails()){
            $data = array(
                "errorCode"         => "400",
                "errorDescription"  => "Fail to Absence",
                "errorMessage"      => $validator->messages()
            );
            return response()->json($data, 400);
        }

        $today = Carbon::today()->toDateTimeString();
        //DB::enableQueryLog(); // Enable query log
        
        $dataAbsence = DB::table('absence')->select('absence.id as absenceid','users.name','users.userid','users.email','users.phone_number','departments.dep_name'
        ,'absence.absence_in','absence.absence_out','absence.absence_sts', 'absence_location.city_name', 'absence_location.region_name', 'absence_location.country_code'
        ,'absence_location.country_name','absence_location.latitude', 'absence_location.longitude', 'absence_location.absence_desc')
        ->where('absence.id', $request->get('id'))->where(DB::raw('DATE(absence.absence_in)'), $today)
        ->join('absence_location', 'absence.id', '=', 'absence_location.id')
        ->join('users', 'absence.userid', '=', 'users.userid')
        ->join('departments', 'users.dept_id', '=', 'departments.id')
        
        ->get()->toArray();

        //dd(DB::getQueryLog()); // Show results of log
        $data = array(
            "errorCode"         => "200",
            "errorDescription"  => "Success",
            "data"      => $dataAbsence
        );
        return response()->json($data, 200);
    }

    public function mime2ext($mime){
        $all_mimes = '{"png":["image\/png","image\/x-png"],"bmp":["image\/bmp","image\/x-bmp",
        "image\/x-bitmap","image\/x-xbitmap","image\/x-win-bitmap","image\/x-windows-bmp",
        "image\/ms-bmp","image\/x-ms-bmp","application\/bmp","application\/x-bmp",
        "application\/x-win-bitmap"],"gif":["image\/gif"],"jpeg":["image\/jpeg",
        "image\/pjpeg"],"xspf":["application\/xspf+xml"],"vlc":["application\/videolan"],
        "wmv":["video\/x-ms-wmv","video\/x-ms-asf"],"au":["audio\/x-au"],
        "ac3":["audio\/ac3"],"flac":["audio\/x-flac"],"ogg":["audio\/ogg",
        "video\/ogg","application\/ogg"],"kmz":["application\/vnd.google-earth.kmz"],
        "kml":["application\/vnd.google-earth.kml+xml"],"rtx":["text\/richtext"],
        "rtf":["text\/rtf"],"jar":["application\/java-archive","application\/x-java-application",
        "application\/x-jar"],"zip":["application\/x-zip","application\/zip",
        "application\/x-zip-compressed","application\/s-compressed","multipart\/x-zip"],
        "7zip":["application\/x-compressed"],"xml":["application\/xml","text\/xml"],
        "svg":["image\/svg+xml"],"3g2":["video\/3gpp2"],"3gp":["video\/3gp","video\/3gpp"],
        "mp4":["video\/mp4"],"m4a":["audio\/x-m4a"],"f4v":["video\/x-f4v"],"flv":["video\/x-flv"],
        "webm":["video\/webm"],"aac":["audio\/x-acc"],"m4u":["application\/vnd.mpegurl"],
        "pdf":["application\/pdf","application\/octet-stream"],
        "pptx":["application\/vnd.openxmlformats-officedocument.presentationml.presentation"],
        "ppt":["application\/powerpoint","application\/vnd.ms-powerpoint","application\/vnd.ms-office",
        "application\/msword"],"docx":["application\/vnd.openxmlformats-officedocument.wordprocessingml.document"],
        "xlsx":["application\/vnd.openxmlformats-officedocument.spreadsheetml.sheet","application\/vnd.ms-excel"],
        "xl":["application\/excel"],"xls":["application\/msexcel","application\/x-msexcel","application\/x-ms-excel",
        "application\/x-excel","application\/x-dos_ms_excel","application\/xls","application\/x-xls"],
        "xsl":["text\/xsl"],"mpeg":["video\/mpeg"],"mov":["video\/quicktime"],"avi":["video\/x-msvideo",
        "video\/msvideo","video\/avi","application\/x-troff-msvideo"],"movie":["video\/x-sgi-movie"],
        "log":["text\/x-log"],"txt":["text\/plain"],"css":["text\/css"],"html":["text\/html"],
        "wav":["audio\/x-wav","audio\/wave","audio\/wav"],"xhtml":["application\/xhtml+xml"],
        "tar":["application\/x-tar"],"tgz":["application\/x-gzip-compressed"],"psd":["application\/x-photoshop",
        "image\/vnd.adobe.photoshop"],"exe":["application\/x-msdownload"],"js":["application\/x-javascript"],
        "mp3":["audio\/mpeg","audio\/mpg","audio\/mpeg3","audio\/mp3"],"rar":["application\/x-rar","application\/rar",
        "application\/x-rar-compressed"],"gzip":["application\/x-gzip"],"hqx":["application\/mac-binhex40",
        "application\/mac-binhex","application\/x-binhex40","application\/x-mac-binhex40"],
        "cpt":["application\/mac-compactpro"],"bin":["application\/macbinary","application\/mac-binary",
        "application\/x-binary","application\/x-macbinary"],"oda":["application\/oda"],
        "ai":["application\/postscript"],"smil":["application\/smil"],"mif":["application\/vnd.mif"],
        "wbxml":["application\/wbxml"],"wmlc":["application\/wmlc"],"dcr":["application\/x-director"],
        "dvi":["application\/x-dvi"],"gtar":["application\/x-gtar"],"php":["application\/x-httpd-php",
        "application\/php","application\/x-php","text\/php","text\/x-php","application\/x-httpd-php-source"],
        "swf":["application\/x-shockwave-flash"],"sit":["application\/x-stuffit"],"z":["application\/x-compress"],
        "mid":["audio\/midi"],"aif":["audio\/x-aiff","audio\/aiff"],"ram":["audio\/x-pn-realaudio"],
        "rpm":["audio\/x-pn-realaudio-plugin"],"ra":["audio\/x-realaudio"],"rv":["video\/vnd.rn-realvideo"],
        "jp2":["image\/jp2","video\/mj2","image\/jpx","image\/jpm"],"tiff":["image\/tiff"],
        "eml":["message\/rfc822"],"pem":["application\/x-x509-user-cert","application\/x-pem-file"],
        "p10":["application\/x-pkcs10","application\/pkcs10"],"p12":["application\/x-pkcs12"],
        "p7a":["application\/x-pkcs7-signature"],"p7c":["application\/pkcs7-mime","application\/x-pkcs7-mime"],"p7r":["application\/x-pkcs7-certreqresp"],"p7s":["application\/pkcs7-signature"],"crt":["application\/x-x509-ca-cert","application\/pkix-cert"],"crl":["application\/pkix-crl","application\/pkcs-crl"],"pgp":["application\/pgp"],"gpg":["application\/gpg-keys"],"rsa":["application\/x-pkcs7"],"ics":["text\/calendar"],"zsh":["text\/x-scriptzsh"],"cdr":["application\/cdr","application\/coreldraw","application\/x-cdr","application\/x-coreldraw","image\/cdr","image\/x-cdr","zz-application\/zz-winassoc-cdr"],"wma":["audio\/x-ms-wma"],"vcf":["text\/x-vcard"],"srt":["text\/srt"],"vtt":["text\/vtt"],"ico":["image\/x-icon","image\/x-ico","image\/vnd.microsoft.icon"],"csv":["text\/x-comma-separated-values","text\/comma-separated-values","application\/vnd.msexcel"],"json":["application\/json","text\/json"]}';
        $all_mimes = json_decode($all_mimes,true);
        foreach ($all_mimes as $key => $value) {
            if(array_search($mime,$value) !== false) return $key;
        }
        return false;
    }
}
