<?php
declare(strict_types=1);

namespace mateocollar\profiler;

use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;
use pocketmine\plugin\PluginBase;

class UpdateChecker {

    public static function init(PluginBase $plugin) {
        $currentVersion = $plugin->getDescription()->getVersion();
        Server::getInstance()->getScheduler()->scheduleAsyncTask(new CheckUpdateTask($currentVersion));
    }
}

class CheckUpdateTask extends AsyncTask {

    private $currentVersion;

    public function __construct(string $currentVersion) {
        $this->currentVersion = $currentVersion;
    }

    public function onRun() {
        $repo = "mateocollar/profiler";
        $url = "https://api.github.com/repos/$repo/releases/latest";
        $userAgent = "PocketMine-Plugin-Profiler";

        if (!function_exists("curl_version")) {
            $this->setResult(["error" => "cURL no está disponible en este servidor."]);
            return;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        
        $json = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($json === false || $httpCode >= 400) {
            $this->setResult(["error" => "No se pudo conectar con GitHub. Código HTTP: " . $httpCode]);
            return;
        }

        $release = json_decode($json, true);
        if (!is_array($release) || !isset($release["tag_name"])) {
            $this->setResult(["error" => "Respuesta de GitHub inválida o no hay releases creadas."]);
            return;
        }

        $this->setResult([
            "latest" => ltrim(trim($release["tag_name"]), "vV "),
            "url" => $release["html_url"] ?? "https://github.com/$repo/releases"
        ]);
    }

    public function onCompletion(Server $server) {
        $result = $this->getResult();
        $logger = $server->getLogger();

        if (isset($result["error"])) {
            $logger->warning("[Profiler] UpdateCheck Error: " . $result["error"]);
            return;
        }

        $latestVersion = $result["latest"];
        $currentVersion = ltrim(trim($this->currentVersion), "vV ");

        if (version_compare($latestVersion, $currentVersion, ">")) {
            $logger->info("§e[Profiler] ¡Nueva versión disponible! v" . $latestVersion);
            $logger->info("§e[Profiler] Descárgala aquí: §b" . $result["url"]);
        } else {
            $logger->info("§a[Profiler] Estás utilizando la última versión estable (v" . $currentVersion . ").");
        }
    }
}
