<?php

class eServiceError {

    const ServiceNotFound = 1;
    const IncorrectPassword = 101;
    const ContentNotFound = 102;
    const ContentBlocked = 103;
    const UserNotFound = 120;
    const ApplicationNotFound = 130;
    const PassiveApplication = 131;
    const CategoryNotFound = 140;
    const IncorrectUserCredentials = 150;
    const CreateAccount = 151;
    const ClientNotFound = 160;
    const ClientIncorrectPassword = 161;
    const ClientInvalidPasswordAttemptsLimit = 162;

    /**
     * 
     * @param type $errorNo
     * @return \Exception
     */
    public static function getException($errorNo) {
	switch ($errorNo) {
	    case eServiceError::ServiceNotFound:
		$exception = new Exception("Servis versiyonu hatalı", eServiceError::ServiceNotFound);
		break;
	    case eServiceError::IncorrectPassword:
		$exception = new Exception("Hatalı parola!", eServiceError::IncorrectPassword);
		break;
	    case eServiceError::ContentNotFound:
		$exception = new Exception("İçerik bulunamadı.", eServiceError::ContentNotFound);
		break;
	    case eServiceError::ContentBlocked:
		$exception = new Exception("İçerik engellenmiş.", eServiceError::ContentBlocked);
		break;
	    case eServiceError::UserNotFound:
		$exception = new Exception("Müşteri bulunamadı.", eServiceError::UserNotFound);
		break;
	    case eServiceError::ApplicationNotFound:
		$exception = new Exception("Uygulama bulunamadı.", eServiceError::ApplicationNotFound);
		break;
	    case eServiceError::PassiveApplication:
		$exception = new Exception("Uygulama aktif değil. Uygulamanın süresi dolmuş, engellenmiş veya pasifleştirilmiş olabilir.", eServiceError::PassiveApplication);
		break;
	    case eServiceError::CategoryNotFound:
		$exception = new Exception("Kategori bulunamadı.", eServiceError::CategoryNotFound);
		break;
	    case eServiceError::IncorrectUserCredentials:
		$exception = new Exception("Hatalı Kullanıcı Bilgileri.", eServiceError::IncorrectUserCredentials);
		break;
	    case eServiceError::CreateAccount:
		$exception = new Exception(Config::get('custom.url') . " adresinden hesap oluşturmalısınız.", eServiceError::CreateAccount);
		break;

	    //client errors
	    case eServiceError::ClientNotFound:
		$exception = new Exception("Kullanıcı Bulunamadı.", eServiceError::ClientNotFound);
		break;
	    case eServiceError::ClientIncorrectPassword:
		$exception = new Exception("Hatalı parola girişi.", eServiceError::ClientIncorrectPassword);
		break;
	    case eServiceError::ClientInvalidPasswordAttemptsLimit:
		$exception = new Exception("Hatalı parola giriş limitiniz doldu. Hesabınızın tekrar aktifleşmesi için 2 saat bekleyiniz.", eServiceError::ClientInvalidPasswordAttemptsLimit);
		break;
	    default:
		$exception = new Exception();
	}
	return $exception;
    }

}
