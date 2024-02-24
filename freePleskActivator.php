<?php
function downloadString($url){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $data = trim(curl_exec($curl));
    curl_close($curl);
    return $data;
}

function defaultHosts(){
    Global $hostsFile;
    $hosts = file($hostsFile, FILE_IGNORE_NEW_LINES);
    foreach($hosts as $key => $line){
        if(strstr($line,'plesk.com')){
            unset($hosts[$key]);
        }
    }
    return $hosts;
}

echo "\n\033[0;36m================ Free Plesk Activator | Powered by Majdev ===============\33[0m\n\n";

if (!function_exists('curl_version')) {
    echo " \33[91mError:\33[0m Curl plugin not found!\n";
    exit;
}

$IP = downloadString("https://myexternalip.com/raw");
if ($IP === false) {
    echo " \33[91mError:\33[0m Unable to retrieve IP address!\n";
    exit;
}

$pleskKeyXML = downloadString("https://raw.githubusercontent.com/inc-Majdev/freePleskActivator/main/plesk_key.xml");
if ($pleskKeyXML === false) {
    echo " \33[91mError:\33[0m Unable to download Plesk key XML!\n";
    exit;
}

$keyIP = downloadString("https://raw.githubusercontent.com/inc-Majdev/freePleskActivator/main/key_ip.txt");
if ($keyIP === false) {
    echo " \33[91mError:\33[0m Unable to download key IP!\n";
    exit;
}

if(is_file('/usr/local/psa/bin/license')){
    $system         = 'Linux';
    $licenseDir     = '/etc/sw/keys';
    $licenseFile    = '/usr/local/psa/bin/license';
    $licenseXMLPath = '/usr/local/psa/bin/license.xml';
    $pleskCSSPath   = '/usr/local/psa/admin/cp/public/theme/css/main.css';
    $pleskCmd       = '/usr/sbin/plesk';
    $execEnd        = ' 2>&1';
    $hostsFile      = '/etc/hosts';
} elseif(is_file('C:\Program Files (x86)\Parallels\Plesk\bin\license.exe')){
    $system         = 'Windows';
    $licenseDir     = 'C:\\Program Files (x86)\\Parallels\\Plesk\\admin\\repository';
    $licenseFile    = 'C:\\Program Files (x86)\\Parallels\\Plesk\\bin\\license.exe';
    $licenseXMLPath = 'C:\\Program Files (x86)\\Parallels\\Plesk\\bin\\license.xml';
    $pleskCSSPath   = 'C:\\Program Files (x86)\\Parallels\\Plesk\\admin\\cp\\public\\theme\\css\\main.css';
    $pleskCmd       = 'C:\\Program Files (x86)\\Parallels\\Plesk\\bin\\plesk.exe';
    $execEnd        = '';
    $hostsFile      = 'C:\Windows\System32\drivers\etc\hosts';
} elseif(is_file('C:\Program Files (x86)\Plesk\bin\license.exe')){
    $system         = 'Windows';
    $licenseDir     = 'C:\\Program Files (x86)\\Plesk\\admin\\repository';
    $licenseFile    = 'C:\\Program Files (x86)\\Plesk\\bin\\license.exe';
    $licenseXMLPath = 'C:\\Program Files (x86)\\Plesk\\bin\\license.xml';
    $pleskCSSPath   = 'C:\\Program Files (x86)\\Plesk\\admin\\cp\\public\\theme\\css\\main.css';
    $pleskCmd       = 'C:\\Program Files (x86)\\Plesk\\bin\\plesk.exe';
    $execEnd        = '';
    $hostsFile      = 'C:\Windows\System32\drivers\etc\hosts';
} elseif(is_file('d:\Program Files (x86)\Plesk\bin\license.exe')){
    $system         = 'Windows';
    $licenseDir     = 'd:\\Program Files (x86)\\Plesk\\admin\\repository';
    $licenseFile    = 'd:\\Program Files (x86)\\Plesk\\bin\\license.exe';
    $licenseXMLPath = 'd:\\Program Files (x86)\\Plesk\\bin\\license.xml';
    $pleskCSSPath   = 'd:\\Program Files (x86)\\Plesk\\admin\\cp\\public\\theme\\css\\main.css';
    $pleskCmd       = 'd:\\Program Files (x86)\\Plesk\\bin\\plesk.exe';
    $execEnd        = '';
    $hostsFile      = 'd:\Windows\System32\drivers\etc\hosts';
} else {
    echo " \33[91mPlesk Not Found!\33[0m\n";
    exit;
}

if(is_file($licenseDir . DIRECTORY_SEPARATOR . 'registry.xml') && filesize($licenseDir . DIRECTORY_SEPARATOR . 'registry.xml') < 2){
    if(is_file('/usr/bin/chattr')){
        shell_exec('/usr/bin/chattr -ia '. $licenseDir. DIRECTORY_SEPARATOR . 'registry.xml');
    }
    unlink($licenseDir . DIRECTORY_SEPARATOR . 'registry.xml');
}

echo " \033[0;35mSystem Detection:\33[97m ".$system."\33[0m\n";
echo " \033[0;35mServer IPv4 Address:\33[97m ". $IP ."\33[0m\n";

if(is_file($licenseFile)){
    if(is_file($pleskCSSPath)){
        $source = file_get_contents($pleskCSSPath);
        if(!strstr($source, '.license-status{display:none;p')){
            $source = str_replace('.license-status{p', '.license-status{display:none;p', $source);
            $source = file_put_contents($pleskCSSPath, $source);
        }
    }

    $hosts = defaultHosts();
    if($IP != $keyIP){
        $hosts[] = $keyIP . ' ka.plesk.com';
        $hosts[] = $keyIP . ' id-00.kaid.plesk.com';
        $hosts[] = $keyIP . ' id-01.kaid.plesk.com';
        $hosts[] = $keyIP . ' id-02.kaid.plesk.com';
        $hosts[] = $keyIP . ' id-03.kaid.plesk.com';
        $hosts[] = $keyIP . ' id-04.kaid.plesk.com';
        $hosts[] = $keyIP . ' id-05.kaid.plesk.com';
        $hosts[] = $keyIP . ' alternate.ka.plesk.com';
        $hosts[] = $keyIP . ' feedback.pp.plesk.com';
    }

    if($system == "Linux"){
        shell_exec('/usr/bin/chattr -ia '. $hostsFile. " " . $execEnd);
    }

    if($system == "Windows"){
        shell_exec('/usr/bin/chattr -ia '. $hostsFile. " " . $execEnd);
        shell_exec('ICACLS "' . $hostsFile . '" /T /Q /C /RESET ' . $execEnd);
    }
    
    chmod($hostsFile, 0777);
    file_put_contents($hostsFile, implode(PHP_EOL, $hosts));

    if(is_file('/usr/bin/chattr')){
        shell_exec('/usr/bin/chattr -ia '. $licenseDir. DIRECTORY_SEPARATOR . 'keys' . DIRECTORY_SEPARATOR . '* ' . $execEnd);
    }

    if($system == "Windows"){
        shell_exec('ICACLS "' . $licenseDir.DIRECTORY_SEPARATOR . 'keys" /T /Q /C /RESET ' . $execEnd);
        shell_exec('ICACLS "' . $licenseDir.DIRECTORY_SEPARATOR . 'keys'. DIRECTORY_SEPARATOR . '*" /inheritance:e ' . $execEnd);
    }

    foreach(scandir($licenseDir . DIRECTORY_SEPARATOR . 'keys' . DIRECTORY_SEPARATOR) as $File){
        if(!in_array($File,['.','..'])){
            unlink($licenseDir . DIRECTORY_SEPARATOR . 'keys'. DIRECTORY_SEPARATOR . $File);
        }
    }

    file_put_contents($licenseDir . DIRECTORY_SEPARATOR . 'keys' .DIRECTORY_SEPARATOR . 'keyXXa08121', $pleskKeyXML);
    file_put_contents($licenseDir . DIRECTORY_SEPARATOR . 'keys' .DIRECTORY_SEPARATOR . 'keyXXa08122', $pleskKeyXML);
    file_put_contents($licenseDir . DIRECTORY_SEPARATOR . 'keys' .DIRECTORY_SEPARATOR . 'keyXXa08123', $pleskKeyXML);
    file_put_contents($licenseDir . DIRECTORY_SEPARATOR . 'keys' .DIRECTORY_SEPARATOR . 'keyXXa08124', $pleskKeyXML);
    file_put_contents($licenseXMLPath, $pleskKeyXML);
    echo " \33[93mLicense Loading...\33[0m\n";

    $exec = trim(shell_exec('"' . $licenseFile . '" -i "' . $licenseXMLPath.'"' . $execEnd));
    if(stristr($exec, 'successfully installed')){
        echo " \33[32mLicense Installed Successfully!\n";
        shell_exec('"'. $pleskCmd . '" db "DELETE FROM psa.sessions";');
        shell_exec('"'. $pleskCmd . '" bin poweruser --off');
    } else {
        echo " \33[91mError: '".$exec."'\33[0m\n";
        exit;
    }

    unlink($licenseXMLPath);

    if(is_file('/usr/bin/chattr')){
        shell_exec('/usr/bin/chattr +ia '. $licenseDir . DIRECTORY_SEPARATOR . 'keys' . DIRECTORY_SEPARATOR . '* ' . $execEnd);
    }

    if(DIRECTORY_SEPARATOR == '\\'){
        shell_exec('ICACLS "C:\Program Files (x86)\Plesk\admin\repository\keys\*" /inheritance:d'.$execEnd);
        shell_exec('ICACLS "C:\Program Files (x86)\Plesk\admin\repository\keys\*" /deny users:D'.$execEnd);
        shell_exec('CACLS "C:\Program Files (x86)\Plesk\admin\repository\keys\*" /E /G users:R'.$execEnd);
        shell_exec('ICACLS "C:\Program Files (x86)\Plesk\admin\repository\keys\*" /deny SYSTEM:D'.$execEnd);
        shell_exec('CACLS "C:\Program Files (x86)\Plesk\admin\repository\keys\*" /E /G SYSTEM:R'.$execEnd);
        shell_exec('ICACLS "C:\Program Files (x86)\Plesk\admin\repository\keys\*" /deny psaadm:D'.$execEnd);
        shell_exec('CACLS "C:\Program Files (x86)\Plesk\admin\repository\keys\*" /E /G psaadm:R'.$execEnd);
        shell_exec('ICACLS "C:\Program Files (x86)\Plesk\admin\repository\keys\*" /deny psaadm_users:D'.$execEnd);
        shell_exec('CACLS "C:\Program Files (x86)\Plesk\admin\repository\keys\*" /E /G psaadm_users:R'.$execEnd);
        shell_exec('ICACLS "C:\Program Files (x86)\Plesk\admin\repository\keys\*" /deny administrators:D'.$execEnd);
        shell_exec('CACLS "C:\Program Files (x86)\Plesk\admin\repository\keys\*" /E /G administrators:R'.$execEnd);
    }

    echo "\n\033[0;36m=========================================================================\33[0m\n\n";
    echo "\33[32mKey Info:\33[0m\n";
    $output = shell_exec('"'. $pleskCmd . '" bin keyinfo --list');
    $lines = explode("\n", $output);
    
    $wantedKeys = ['edition-name', 'plesk_key_id', 'lim_date'];
    $keyLabels = [
        'edition-name' => 'Edition Name',
        'plesk_key_id' => 'Plesk Key ID',
        'lim_date' => 'License Expiry Date'
    ];
    
    foreach ($lines as $line) {
        $parts = explode(': ', $line);
        if (count($parts) === 2 && in_array($parts[0], $wantedKeys)) {
            $key = $parts[0];
            $value = $parts[1];
            if ($key === 'lim_date') {
                $value = date('Y-m-d', strtotime($value));
            }
            $label = isset($keyLabels[$key]) ? $keyLabels[$key] : $key;
            echo $label . ': ' . $value . PHP_EOL;
        }
    }
    echo "\n\033[0;36m=========================================================================\33[0m\n\n";
}
