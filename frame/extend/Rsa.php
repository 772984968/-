<?php
namespace yii\extend;
use Yii;
class Rsa {
    private static $PRIVATE_KEY ;
    private static $PUBLIC_KEY ;

    public function __construct()
    {
        $file = dirname(dirname(Yii::$app->basePath)) . DIRECTORY_SEPARATOR . 'key' . DIRECTORY_SEPARATOR . 'rsa_public_key.pem';
        self::$PUBLIC_KEY = file_get_contents($file);

        $file = dirname(dirname(Yii::$app->basePath)) . DIRECTORY_SEPARATOR . 'key' . DIRECTORY_SEPARATOR . 'rsa_private_key.pem';
        self::$PRIVATE_KEY = file_get_contents($file);
        
    }

    /**
     * 获取私钥
     * @return bool|resource
     */
    private static function getPrivateKey()
    {
        $privKey = self::$PRIVATE_KEY;
        return openssl_pkey_get_private($privKey);
    }

    /**
     * 获取公钥
     * @return bool|resource
     */
    private static function getPublicKey()
    {
        $publicKey = self::$PUBLIC_KEY;
        return openssl_pkey_get_public($publicKey);
    }

    public static function publickey()
    {
        return self::$PUBLIC_KEY;
    }

    public static function privatekey()
    {
        return self::$PRIVATE_KEY;
    }

    /**
     * 私钥加密
     * @param string $data
     * @return null|string
     */
    public static function privEncrypt($data = '')
    {
        if (!is_string($data)) {
            return null;
        }
        return openssl_private_encrypt($data,$encrypted,self::getPrivateKey()) ? base64_encode($encrypted) : null;
    }

    /**
     * 公钥加密
     * @param string $data
     * @return null|string
     */
    public static function publicEncrypt($data = '')
    {
        if (!is_string($data)) {
            return null;
        }
        return openssl_public_encrypt($data,$encrypted,self::getPublicKey()) ? base64_encode($encrypted) : null;
    }

    /**
     * 私钥解密
     * @param string $encrypted
     * @return null
     */
    public static function privDecrypt($encrypted = '')
    {
        if (!is_string($encrypted)) {
            return null;
        }
        return (openssl_private_decrypt(base64_decode($encrypted), $decrypted, self::getPrivateKey())) ? $decrypted : null;
    }

    /**
     * 公钥解密
     * @param string $encrypted
     * @return null
     */
    public static function publicDecrypt($encrypted = '')
    {
        if (!is_string($encrypted)) {
            return null;
        }
        return (openssl_public_decrypt(base64_decode($encrypted), $decrypted, self::getPublicKey())) ? $decrypted : null;
    }
}