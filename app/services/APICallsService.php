<?php
/**
 *
 * File: APICallsService.php
 *
 * Created by Yiannis Kiranis <rocean74@gmail.com>
 * http://www.apps4net.eu
 *
 * Date: 26/1/24
 * Time: 12:10 μ.μ.
 *
 */

namespace apps4net\syncDB\services;

class APICallsService
{

    /**
     * Read audit trail table from remote machine
     *
     * @return mixed
     * @throws \Exception
     */
    public function readAuditTrail(): mixed
    {
        $remoteURL = $_ENV['REMOTE_API_URL'] . "/readAuditTrail";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $remoteURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // Add this line
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // Add this line
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));

        try {
            $response = curl_exec($ch);
        } catch (\Exception $e) {
            throw new \Exception('Caught exception: ' . $e->getMessage());
        }
        curl_close($ch);

        // Check for error
        if ($response === false) {
            throw new \Exception(curl_error($ch));
        }

        // Check for HTTP status code != 200
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        error_log($responseCode);
        if ($responseCode != 200) {
            if($responseCode === 500) {
                throw new \Exception("Remote server error");
            }

            $response = json_decode($response, true);
            throw new \Exception($response['message']);
        }

        return json_decode($response, true);
    }

    /**
     * Delete imported records from remote audit trail table
     *
     * @param int $lastRecordInserted
     * @return mixed
     * @throws \Exception
     */
    public function deleteImportedRecords(int $lastRecordInserted): mixed
    {
        $remoteURL = $_ENV['REMOTE_API_URL'] . "/deleteImportedRecords?lastRecordInserted=" . $lastRecordInserted;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $remoteURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // Add this line
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // Add this line
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));

        try {
            $response = curl_exec($ch);
        } catch (\Exception $e) {
            throw new \Exception('Caught exception: ' . $e->getMessage());
        }
        curl_close($ch);

        // Check for error
        if ($response === false) {
            throw new \Exception(curl_error($ch));
        }

        // Check for HTTP status code != 200
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($responseCode != 200) {
            if($responseCode === 500) {
                throw new \Exception("Remote server error");
            }

            $response = json_decode($response, true);
            throw new \Exception($response['message']);
        }

        return json_decode($response, true);
    }

    /**
     * Get the checksums of all tables from remote machine
     *
     * @throws \Exception
     */
    public function getRemoteChecksums(): array
    {
        $remoteURL = $_ENV['REMOTE_API_URL'] . "/getChecksums";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $remoteURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // Add this line
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // Add this line
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));

        try {
            $response = curl_exec($ch);
        } catch (\Exception $e) {
            throw new \Exception('Caught exception: ' . $e->getMessage());
        }
        curl_close($ch);

        // Check for error
        if ($response === false) {
            throw new \Exception(curl_error($ch));
        }

        // Check for HTTP status code != 200
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($responseCode != 200) {
            if($responseCode === 500) {
                throw new \Exception("Remote server error");
            }

            $response = json_decode($response, true);
            throw new \Exception($response['message']);
        }

        return json_decode($response, true);
    }
}
