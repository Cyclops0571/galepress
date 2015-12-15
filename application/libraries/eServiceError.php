<?php

class eServiceError {

    const ServiceNotFound = 1;
    const IncorrectPassword = 101;
    const ContentNotFound = 102;
    const ContentBlocked = 103;
    const UserNotFound = 120;
    const ApplicationNotFound = 130;
    const PassiveApplication = 131;
    const IncorrectUserCredentials = 140;
    const CategoryNotFound = 150;
    const CreateAccount = 151;
    const ClientNotFound = 160;
    const ClientIncorrectPassword = 161;
    const ClientInvalidPasswordAttemptsLimit = 162;
    const GenericError = 400;

    const ContentNotFoundMessage = 'İçerik bulunamadı.';

    /**
     * 
     * @param type $errorNo
     * @return \Exception
     */
    public static function getException($errorNo, $errorMsg = "") {
	switch ($errorNo) {
	    case eServiceError::ServiceNotFound:
		$exception = new Exception("Servis versiyonu hatalı", $errorNo);
		break;
	    case eServiceError::IncorrectPassword:
		$exception = new Exception("Hatalı parola!", $errorNo);
		break;
	    case eServiceError::ContentNotFound:
		$exception = new Exception(self::ContentNotFoundMessage, $errorNo);
		break;
	    case eServiceError::ContentBlocked:
		$exception = new Exception("İçerik engellenmiş.", $errorNo);
		break;
	    case eServiceError::UserNotFound:
		$exception = new Exception("Müşteri bulunamadı.", $errorNo);
		break;
	    case eServiceError::ApplicationNotFound:
		$exception = new Exception("Uygulama bulunamadı.", $errorNo);
		break;
	    case eServiceError::PassiveApplication:
		$exception = new Exception("Uygulama aktif değil. Uygulamanın süresi dolmuş, engellenmiş veya pasifleştirilmiş olabilir.", $errorNo);
		break;
	    case eServiceError::IncorrectUserCredentials:
		$exception = new Exception("Hatalı Kullanıcı Bilgileri.", $errorNo);
		break;
	    case eServiceError::CategoryNotFound:
		$exception = new Exception("Kategori bulunamadı.", $errorNo);
		break;
	    case eServiceError::CreateAccount:
		$exception = new Exception(Config::get('custom.url') . " adresinden hesap oluşturmalısınız.", $errorNo);
		break;

	    //client errors
	    case eServiceError::ClientNotFound:
		$exception = new Exception("Kullanıcı Bulunamadı.", $errorNo);
		break;
	    case eServiceError::ClientIncorrectPassword:
		$exception = new Exception("Hatalı parola girişi.", $errorNo);
		break;
	    case eServiceError::ClientInvalidPasswordAttemptsLimit:
		$exception = new Exception("Hatalı parola giriş limitiniz doldu. Hesabınızın tekrar aktifleşmesi için 2 saat bekleyiniz.", $errorNo);
		break;
	    case eServiceError::GenericError:
		$exception = new Exception($errorMsg, $errorNo);
		break;
	    default:
		$exception = new Exception();
	}
	return $exception;
    }

}
