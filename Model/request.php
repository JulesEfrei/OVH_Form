<?php

    trait Request {

        static function init() {

            $req = curl_init();

            return $req;

        }

    }

    class GetReq {

        use Request;

        public function makeGetReq($url) {

            $req = self::init();

            curl_setopt($req, CURLOPT_URL, $url);
            curl_setopt($req, CURLOPT_RETURNTRANSFER, true);

            $res = curl_exec($req);

            return $res;

        }
    }

    class PostReq {

        use Request;

        public function makePostReq($url, $body) {

            $req = self::init();

            curl_setopt($req, CURLOPT_URL, $url);
            curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($req, CURLOPT_POST, true);
            curl_setopt($req, CURLOPT_POSTFIELDS, json_encode($body));

            $res = curl_exec($req);

            return $res;

        }
    }