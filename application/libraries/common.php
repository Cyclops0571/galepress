<?php

class Common
{

    public static function dirsize($dir)
    {
        if (is_file($dir))
            return filesize($dir);
        if ($dh = opendir($dir)) {
            $size = 0;
            while (($file = readdir($dh)) !== false) {
                if ($file == '.' || $file == '..')
                    continue;
                $s = Common::dirsize($dir . '/' . $file);
                $size += $s;
            }
            closedir($dh);
            return $size;
        }
        return 0;
    }

    public static function xmlEscape($string)
    {
        return str_replace(array('&', '<', '>', '\'', '"'), array('&amp;', '&lt;', '&gt;', '&apos;', '&quot;'), $string);
    }

    public static function CheckCategoryOwnership($categoryID)
    {
        $currentUser = Auth::User();

        if ((int)$currentUser->UserTypeID == eUserTypes::Customer) {
            $count = DB::table('Customer AS c')
                ->join('Application AS a', function ($join) {
                    $join->on('a.CustomerID', '=', 'c.CustomerID');
                    $join->on('a.StatusID', '=', DB::raw(eStatus::Active));
                })
                ->join('Category AS t', function ($join) use ($categoryID) {
                    $join->on('t.CategoryID', '=', DB::raw($categoryID));
                    $join->on('t.ApplicationID', '=', 'a.ApplicationID');
                    $join->on('t.StatusID', '=', DB::raw(eStatus::Active));
                })
                ->where('c.CustomerID', '=', $currentUser->CustomerID)
                ->where('c.StatusID', '=', eStatus::Active)
                ->count();
            if ($count > 0) {
                return true;
            }
            return false;
        } else {
            return true;
        }
    }

    public static function CheckCategoryOwnershipWithApplication($applicationID, $categoryID)
    {
        $currentUser = Auth::User();

        $chk4Application = Common::CheckApplicationOwnership($applicationID);

        if ($chk4Application) {
            if ((int)$currentUser->UserTypeID == eUserTypes::Customer) {
                $count = DB::table('Customer AS c')
                    ->join('Application AS a', function ($join) use ($applicationID) {
                        $join->on('a.ApplicationID', '=', DB::raw($applicationID));
                        $join->on('a.CustomerID', '=', 'c.CustomerID');
                        $join->on('a.StatusID', '=', DB::raw(eStatus::Active));
                    })
                    ->join('Category AS t', function ($join) use ($categoryID) {
                        $join->on('t.CategoryID', '=', DB::raw($categoryID));
                        $join->on('t.ApplicationID', '=', 'a.ApplicationID');
                        $join->on('t.StatusID', '=', DB::raw(eStatus::Active));
                    })
                    ->where('c.CustomerID', '=', $currentUser->CustomerID)
                    ->where('c.StatusID', '=', eStatus::Active)
                    ->count();
                if ($count > 0) {
                    return true;
                }
            } else {
                $count = DB::table('Category')
                    ->where('CategoryID', '=', $categoryID)
                    ->where('ApplicationID', '=', $applicationID)
                    ->where('StatusID', '=', eStatus::Active)
                    ->count();
                if ($count > 0) {
                    return true;
                }
            }
        }
        return false;
    }

    public static function CheckContentPasswordOwnership($contentPasswordID)
    {
        $currentUser = Auth::User();

        if ((int)$currentUser->UserTypeID == eUserTypes::Customer) {
            $count = DB::table('Customer AS c')
                ->join('Application AS a', function ($join) {
                    $join->on('a.CustomerID', '=', 'c.CustomerID');
                    $join->on('a.StatusID', '=', DB::raw(eStatus::Active));
                })
                ->join('Content AS cn', function ($join) {
                    $join->on('cn.ApplicationID', '=', 'a.ApplicationID');
                    $join->on('cn.StatusID', '=', DB::raw(eStatus::Active));
                })
                ->join('ContentPassword AS cp', function ($join) use ($contentPasswordID) {
                    $join->on('cp.ContentPasswordID', '=', DB::raw($contentPasswordID));
                    $join->on('cp.ContentID', '=', 'cn.ContentID');
                    $join->on('cp.StatusID', '=', DB::raw(eStatus::Active));
                })
                ->where('c.CustomerID', '=', $currentUser->CustomerID)
                ->where('c.StatusID', '=', eStatus::Active)
                ->count();
            if ($count > 0) {
                return true;
            }
            return false;
        } else {
            return true;
        }
    }

    public static function CheckApplicationOwnership($applicationID)
    {
        $currentUser = Auth::User();
        if ($currentUser == NULL) {
            return FALSE;
        }

        if ((int)$currentUser->UserTypeID == eUserTypes::Manager) {
            return true;
        }

        if ((int)$applicationID == 0) {
            return FALSE;
        }

        if ((int)$currentUser->UserTypeID == eUserTypes::Customer) {
            $a = Application::find($applicationID);
            if ($a) {
                if ((int)$a->StatusID == eStatus::Active) {
                    $c = $a->Customer();
                    if ((int)$c->StatusID == eStatus::Active) {
                        if ((int)$currentUser->CustomerID == (int)$c->CustomerID) {
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }

    public static function CheckContentOwnership($contentID)
    {
        $currentUser = Auth::User();

        if ((int)$currentUser->UserTypeID == eUserTypes::Customer) {
            $o = Content::find($contentID);
            if ($o) {
                if ((int)$o->StatusID == eStatus::Active) {
                    $a = $o->Application();
                    if ((int)$a->StatusID == eStatus::Active) {
                        $c = $a->Customer();
                        if ((int)$c->StatusID == eStatus::Active) {
                            if ((int)$currentUser->CustomerID == (int)$c->CustomerID) {
                                return true;
                            }
                        }
                    }
                }
            }
            return false;
        } else {
            return true;
        }
    }

    public static function AuthInteractivity($applicationID)
    {
        if (Common::CheckApplicationOwnership($applicationID)) {
            $a = Application::find($applicationID);
            if ($a) {
                return (1 == (int)$a->Package()->Interactive);
            }
        }
        return false;
    }

    public static function AuthMaxPDF($applicationID)
    {
        if (Common::CheckApplicationOwnership($applicationID)) {
            $currentPDF = (int)Content::where('ApplicationID', '=', $applicationID)->where('Status', '=', 1)->where('StatusID', '=', eStatus::Active)->count();
            $maxPDF = 0;

            $a = Application::find($applicationID);
            if ($a) {
                $maxPDF = (int)Application::find($applicationID)->Package()->MaxActivePDF;
                if ($currentPDF < $maxPDF) {
                    return true;
                }
            }
        }
        return false;
    }

    public static function getContentDetail($ContentID, $Password, &$oCustomerID, &$oApplicationID, &$oContentID, &$oContentFileID, &$oContentFilePath, &$oContentFileName)
    {
        $oCustomerID = 0;
        $oApplicationID = 0;
        $oContentID = 0;
        $oContentFileID = 0;
        $oContentFilePath = '';
        $oContentFileName = '';

        $c = DB::table('Customer AS c')
            ->join('Application AS a', function ($join) {
                $join->on('a.CustomerID', '=', 'c.CustomerID');
                $join->on('a.StatusID', '=', DB::raw(eStatus::Active));
            })
            ->join('Content AS o', function ($join) use ($ContentID) {
                $join->on('o.ContentID', '=', DB::raw($ContentID));
                $join->on('o.ApplicationID', '=', 'a.ApplicationID');
                $join->on('o.StatusID', '=', DB::raw(eStatus::Active));
            })
            ->where('c.StatusID', '=', eStatus::Active)
            ->first(array('c.CustomerID', 'a.ApplicationID', 'o.ContentID', 'o.IsProtected'));
        if ($c) {
            $oCustomerID = (int)$c->CustomerID;
            $oApplicationID = (int)$c->ApplicationID;
            $oContentID = (int)$c->ContentID;
            $IsProtected = (int)$c->IsProtected;
            if ($IsProtected == 1) {
                //Content
                $authPwd = false;
                $checkPwd = DB::table('Content')
                    ->where('ContentID', '=', $oContentID)
                    ->where('StatusID', '=', eStatus::Active)
                    ->first();
                if ($checkPwd) {
                    $authPwd = Hash::check($Password, $checkPwd->Password);
                }
                //Content password
                $authPwdList = false;
                $checkPwdList = DB::table('ContentPassword')
                    ->where('ContentID', '=', $oContentID)
                    ->where('StatusID', '=', eStatus::Active)
                    ->get();
                if ($checkPwdList) {
                    foreach ($checkPwdList as $pwd) {
                        if ((int)$pwd->Qty > 0) {
                            if (Hash::check($Password, $pwd->Password)) {
                                $authPwdList = true;
                                //dec counter
                                $current = ContentPassword::find($pwd->ContentPasswordID);
                                if ((int)$current->Qty > 0) {
                                    $current->Qty = $current->Qty - 1;
                                    $current->save();
                                }
                                break;
                            }
                        }
                    }
                }

                if (!($authPwd || $authPwdList)) {
                    throw new Exception(__('common.contents_wrongpassword'), "101");
                }
            }

            $cf = DB::table('ContentFile')
                ->where('ContentID', '=', $oContentID)
                ->where('StatusID', '=', eStatus::Active)
                ->order_by('ContentFileID', 'DESC')
                ->first();
            if ($cf) {
                $oContentFileID = (int)$cf->ContentFileID;
                $oContentFilePath = $cf->FilePath;
                $oContentFileName = $cf->FileName;

                if ((int)$cf->Interactivity == 1) {
                    //$oContentFilePath = $cf->InteractiveFilePath;
                    //$oContentFileName = $cf->InteractiveFileName;
                    if ((int)$cf->HasCreated == 1) {
                        $oContentFilePath = $cf->InteractiveFilePath;
                        $oContentFileName = $cf->InteractiveFileName;
                    } else {
                        throw new Exception(__('common.contents_interactive_file_hasnt_been_created'), "104");
                    }
                }
            } else {
                throw new Exception(__('common.list_norecord'), "102");
            }
        } else {
            throw new Exception(__('common.list_norecord'), "102");
        }
    }

    public static function getContentDetailWithCoverImage(
        $ContentID, &$oCustomerID, &$oApplicationID, &$oContentID, &$oContentFileID, &$oContentFilePath, &$oContentFileName, &$oContentCoverImageFileID, &$oContentCoverImageFilePath, &$oContentCoverImageFileName, &$oContentCoverImageFileName2)
    {
        $oCustomerID = 0;
        $oApplicationID = 0;
        $oContentID = 0;
        $oContentFileID = 0;
        $oContentFilePath = '';
        $oContentFileName = '';
        $oContentCoverImageFileID = 0;
        $oContentCoverImageFilePath = '';
        $oContentCoverImageFileName = '';
        $oContentCoverImageFileName2 = '';

        $c = DB::table('Customer AS c')
            ->join('Application AS a', function ($join) {
                $join->on('a.CustomerID', '=', 'c.CustomerID');
                $join->on('a.StatusID', '=', DB::raw(eStatus::Active));
            })
            ->join('Content AS o', function ($join) use ($ContentID) {
                $join->on('o.ContentID', '=', DB::raw($ContentID));
                $join->on('o.ApplicationID', '=', 'a.ApplicationID');
                $join->on('o.StatusID', '=', DB::raw(eStatus::Active));
            })
            ->where('c.StatusID', '=', eStatus::Active)
            ->first(array('c.CustomerID', 'a.ApplicationID', 'o.ContentID', 'o.IsProtected'));
        if ($c) {
            $oCustomerID = (int)$c->CustomerID;
            $oApplicationID = (int)$c->ApplicationID;
            $oContentID = (int)$c->ContentID;

            $cf = DB::table('ContentFile')
                ->where('ContentID', '=', $oContentID)
                ->where('StatusID', '=', eStatus::Active)
                ->order_by('ContentFileID', 'DESC')
                ->first();
            if ($cf) {
                $oContentFileID = (int)$cf->ContentFileID;
                $oContentFilePath = $cf->FilePath;
                $oContentFileName = $cf->FileName;

                if ((int)$cf->Interactivity == 1) {
                    //$oContentFilePath = $cf->InteractiveFilePath;
                    //$oContentFileName = $cf->InteractiveFileName;
                    if ((int)$cf->HasCreated == 1) {
                        //$oContentFilePath = $cf->InteractiveFilePath;
                        //$oContentFileName = $cf->InteractiveFileName;
                        $oContentFilePath = '';
                        $oContentFileName = '';
                    } else {
                        //Cover image oldugundan engellenmemeli!!!
                        //throw new Exception(__('common.contents_interactive_file_hasnt_been_created'), "104");
                    }
                }

                $cif = DB::table('ContentCoverImageFile')
                    ->where('ContentFileID', '=', $oContentFileID)
                    ->where('StatusID', '=', eStatus::Active)
                    ->order_by('ContentCoverImageFileID', 'DESC')
                    ->first();
                if ($cif) {
                    $oContentCoverImageFileID = (int)$cif->ContentCoverImageFileID;
                    $oContentCoverImageFilePath = $cif->FilePath;
                    $oContentCoverImageFileName = $cif->FileName;
                    $oContentCoverImageFileName2 = $cif->FileName2;
                } else {
                    throw new Exception(__('common.list_norecord'), "102");
                }
            } else {
                throw new Exception(__('common.list_norecord'), "102");
            }
        } else {
            throw new Exception(__('common.list_norecord'), "102");
        }
    }

    public static function download($RequestTypeID, $CustomerID, $ApplicationID, $ContentID, $ContentFileID, $ContentCoverImageFileID, $filepath, $filename)
    {
        $file = path('public') . $filepath . '/' . $filename;

        if (file_exists($file) && is_file($file)) {
            $fileSize = File::size($file);
            //throw new Exception($fileSize);

            $dataTransferred = 0;
            $percentage = 0;

            $r = new Requestt();
            $r->RequestTypeID = $RequestTypeID;
            $r->CustomerID = $CustomerID;
            $r->ApplicationID = $ApplicationID;
            $r->ContentID = $ContentID;
            $r->ContentFileID = $ContentFileID;
            if ($ContentCoverImageFileID > 0) {
                $r->ContentCoverImageFileID = $ContentCoverImageFileID;
            }
            $r->RequestDate = new DateTime();
            $r->IP = Request::ip(); //getenv("REMOTE_ADDR")
            $r->DeviceType = $_SERVER['HTTP_USER_AGENT']; //Holmes::get_device();
            $r->FileSize = $fileSize;
            $r->DataTransferred = 0;
            $r->Percentage = 0;
            $r->StatusID = eStatus::Active;
            $r->CreatorUserID = 0;
            $r->DateCreated = new DateTime();
            $r->ProcessUserID = 0;
            $r->ProcessDate = new DateTime();
            $r->ProcessTypeID = eProcessTypes::Insert;
            $r->save();

            $requestID = $r->RequestID;

            // set the download rate limit (=> 200,0 kb/s)
            $download_rate = 200.0;

            // send headers
            ob_end_clean();
            set_time_limit(0);
            header("Cache-Control: no-store, no-cache, must-revalidate");
            header("Cache-Control: post-check=0, pre-check=0", FALSE);
            header("Pragma: no-cache");
            header("Expires: " . GMDATE("D, d M Y H:i:s", MKTIME(DATE("H") + 2, DATE("i"), DATE("s"), DATE("m"), DATE("d"), DATE("Y"))) . " GMT");
            header("Last-Modified: " . GMDATE("D, d M Y H:i:s") . " GMT");
            header("Content-Type: application/octet-stream");
            header("Content-Length: " . $fileSize);
            header('Content-Disposition: inline; filename="' . str_replace(" ", "_", $filename) . '"'); //dosya isminde bosluk varsa problem oluyor!!!
            header("Content-Transfer-Encoding: binary\n");

            // open file stream
            $fc = fopen($file, "r");

            //http://psoug.org/snippet/Download_File_To_Client_53.htm
            //http://stackoverflow.com/questions/1507985/php-determine-how-many-bytes-sent-over-http
            //http://php.net/manual/en/function.ignore-user-abort.php
            //http://php.net/manual/en/function.http-send-file.php
            //http://stackoverflow.com/questions/737045/send-a-file-to-client
            //SELECT RequestID, FileSize, DataTransferred, Percentage FROM Request ORDER BY RequestID DESC LIMIT 10;
            //ignore_user_abort(true);

            while (!feof($fc) && connection_status() == 0) {

                //echo fread($fc, round($download_rate * 1024));
                print fread($fc, round($download_rate * 1024));

                // flush the content to the browser
                flush();

                //$dataTransferred = $dataTransferred + round($download_rate * 1024);
                //$dataTransferred = $dataTransferred + strlen($contents);
                $dataTransferred = ftell($fc);
                $percentage = ($dataTransferred * 100) / $fileSize;

                $r = Requestt::find($requestID);
                $r->DataTransferred = $dataTransferred;
                $r->Percentage = $percentage;
                $r->ProcessUserID = 0;
                $r->ProcessDate = new DateTime();
                $r->ProcessTypeID = eProcessTypes::Update;
                $r->save();
            }

            // close file stream
            fclose($fc);
        } else {
            throw new Exception(__('common.file_notfound'), "102");
        }
    }

    public static function downloadImage($ContentID, $RequestTypeID, $Width, $Height)
    {
        $content = DB::table('Customer AS c')
            ->join('Application AS a', function ($join) {
                $join->on('a.CustomerID', '=', 'c.CustomerID');
                $join->on('a.StatusID', '=', DB::raw(eStatus::Active));
            })
            ->join('Content AS o', function ($join) use ($ContentID) {
                $join->on('o.ContentID', '=', DB::raw($ContentID));
                $join->on('o.ApplicationID', '=', 'a.ApplicationID');
                $join->on('o.StatusID', '=', DB::raw(eStatus::Active));
            })
            ->where('c.StatusID', '=', eStatus::Active)
            ->first(array('c.CustomerID', 'a.ApplicationID', 'o.ContentID', 'o.IsProtected'));
        if (!$content) {
            throw new Exception(__('common.list_norecord'), "102");
        }
        $contentFile = DB::table('ContentFile')
            ->where('ContentID', '=', $ContentID)
            ->where('StatusID', '=', eStatus::Active)
            ->order_by('ContentFileID', 'DESC')
            ->first();

        if (!$contentFile) {
            throw new Exception(__('common.list_norecord'), "102");
        }
        $contentCoverImageFile = DB::table('ContentCoverImageFile')
            ->where('ContentFileID', '=', $contentFile->ContentFileID)
            ->where('StatusID', '=', eStatus::Active)
            ->order_by('ContentCoverImageFileID', 'DESC')
            ->first();
        if (!$contentCoverImageFile) {
            throw new Exception(__('common.list_norecord'), "102");
        }

        if ($Width > 0 && $Height > 0) {
            //image var mi kontrol edip yok ise olusturup, ismini set edelim;
            $originalImage = path('public') . $contentCoverImageFile->FilePath . '/' . IMAGE_CROPPED_2048;
            if (!is_file($originalImage)) {
                $originalImage = path('public') . $contentCoverImageFile->FilePath . '/' . $contentCoverImageFile->SourceFileName;
            }
            $pathInfoOI = pathinfo($originalImage);
            $fileName = IMAGE_CROPPED_NAME . "_" . $Width . "x" . $Height . ".jpg";
            if (!is_file($pathInfoOI["dirname"] . "/" . $fileName)) {
                //resize original image to new path and then save it.
                if (!is_file($originalImage)) {
                    throw new Exception(__('common.file_notfound'), "102");
                }
                $im = new Imagick($originalImage);
                $im->resizeImage($Width, $Height, Imagick::FILTER_LANCZOS, 1, TRUE);
                $im->writeImage($pathInfoOI["dirname"] . "/" . $fileName);
                $im->destroy();
            }
        } else {
            switch ($RequestTypeID) {
                case SMALL_IMAGE_FILE:
                    $fileName = $contentCoverImageFile->FileName2;
                    break;
                case NORMAL_IMAGE_FILE:
                    $fileName = $contentCoverImageFile->FileName2;
                    break;
                default:
                    throw new Exception('Not implemented', '102');
            }
        }


        $file = path('public') . $contentCoverImageFile->FilePath . '/' . $fileName;
        if (!is_file($file)) {
            throw new Exception(__('common.file_notfound'), "102");
        }
        $fileSize = File::size($file);
        $r = new Requestt();
        $r->RequestTypeID = $RequestTypeID;
        $r->CustomerID = (int)$content->CustomerID;
        $r->ApplicationID = (int)$content->ApplicationID;
        $r->ContentID = $ContentID;
        $r->ContentFileID = (int)$contentFile->ContentFileID;
        $r->ContentCoverImageFileID = $contentCoverImageFile->ContentCoverImageFileID;
        $r->RequestDate = new DateTime();
        $r->IP = Request::ip();
        $r->DeviceType = $_SERVER['HTTP_USER_AGENT']; //Holmes::get_device();
        $r->FileSize = $fileSize;
        $r->DataTransferred = 0;
        $r->Percentage = 0;
        $r->StatusID = eStatus::Active;
        $r->CreatorUserID = 0;
        $r->DateCreated = new DateTime();
        $r->ProcessUserID = 0;
        $r->ProcessDate = new DateTime();
        $r->ProcessTypeID = eProcessTypes::Insert;
        $r->save();

        $requestID = $r->RequestID;

        // set the download rate limit (=> 200,0 kb/s)
        $download_rate = 200.0;

        // send headers
        ob_end_clean();
        set_time_limit(0);
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", FALSE);
        header("Pragma: no-cache");
        header("Expires: " . GMDATE("D, d M Y H:i:s", MKTIME(DATE("H") + 2, DATE("i"), DATE("s"), DATE("m"), DATE("d"), DATE("Y"))) . " GMT");
        header("Last-Modified: " . GMDATE("D, d M Y H:i:s") . " GMT");
        header("Content-Type: application/octet-stream");
        header("Content-Length: " . $fileSize);
        header('Content-Disposition: inline; filename="' . str_replace(" ", "_", $fileName) . '"'); //dosya isminde bosluk varsa problem oluyor!!!
        header("Content-Transfer-Encoding: binary\n");
        // open file stream
        $fc = fopen($file, "r");
        while (!feof($fc) && connection_status() == 0) {
            //echo fread($fc, round($download_rate * 1024));
            print fread($fc, round($download_rate * 1024));

            // flush the content to the browser
            flush();
            $dataTransferred = ftell($fc);
            $percentage = ($dataTransferred * 100) / $fileSize;

            $r = Requestt::find($requestID);
            $r->DataTransferred = $dataTransferred;
            $r->Percentage = $percentage;
            $r->ProcessUserID = 0;
            $r->ProcessDate = new DateTime();
            $r->ProcessTypeID = eProcessTypes::Update;
            $r->save();
        }
        fclose($fc);
    }

    /**
     * Sends Error Email to custom.admin_email_set and Logs it
     * @param error $msg
     */
    public static function sendErrorMail($msg)
    {
        $toEmailSet = Config::get('custom.admin_email_set');
        $subject = __('common.task_subject');
        Log::info($msg);
        Laravel\Log::write($type, $message);
        Bundle::start('messages');
        foreach ($toEmailSet as $toEmail) {
            Message::send(function ($m) use ($toEmail, $subject, $msg) {
                $m->from(Config::get('custom.mail_email'), Config::get('custom.mail_displayname'));
                $m->to($toEmail);
                $m->subject($subject);
                $m->body($msg);
            });
        }
    }

    public static function sendPaymentUserSuccesMail($username, $email, $amount)
    {
        Bundle::start('messages');
        Message::send(function ($m) use ($username, $email, $amount) {
            $body = "Sayın " . $username . ", \r\n"
                . "Galepress Dijital Yayin Platformundan aldığınız ürünün otomatik ödemesi " . $amount . "TL  hesabınızdan tahsil edilmiştir. \r\n"
                . "Firmamız adına teşekkür eder iyi günler dileriz.\r\n\r\n\r\n"
                . "Saygılarımızla Galepress";
            $m->from(Config::get('custom.mail_email'), Config::get('custom.mail_displayname'));
            $m->to($email);
            $m->subject("Galepress Dijital Yayin Platformu Otomatik Ödeme Maili");
            $m->body($body);
        });
    }

    public static function sendPaymentUserReminderMail($userList)
    {
        return; //571571
        Bundle::start('messages');
        foreach ($userList as $user) {
            if (!in_array($user["warning_mail_phase"], array(1, 2, 3))) {
                continue;
            }

            Message::send(function ($m) use ($user) {
                $msg = "";
                switch ($user["warning_mail_phase"]) {
                    case 1:
                        $msg = "Değerli Müşterimiz, \r\n\r\n"
                            . "Bekleyen bir ödemeniz bulunmaktadır ve iki hafta içinde ödemenizi tamamlamanız gerekmektedir. "
                            . "İlginiz için teşekkür eder, sizinle çalışmaktan mutluluk duymaktayız. \r\n\r\n"
                            . "Eğer ödemenizi gerçekleştirdiyseniz bu maili dikkate almayabilirsiniz. \r\n\r\n"
                            . "İyi çalışmalar.";
                        break;
                    case 2:
                        $msg = "Değerli Müşterimiz, \r\n\r\n"
                            . "Borcunuzun son ödeme tarihi 7 gün sonradır, en kısa zamanda ödemenizi gerçekleştirmeniz gerekmektedir. "
                            . "İlginiz için teşekkür eder, sizinle çalışmaktan mutluluk duymaktayız. \r\n\r\n"
                            . "Eğer ödemenizi gerçekleştirdiyseniz bu maili dikkate almayabilirsiniz. \r\n\r\n"
                            . "İyi çalışmalar.";
                        break;
                    case 3:
                        $msg = "Değerli Müşterimiz, \r\n\r\n"
                            . "Borcunuzu 3 gün içinde ödemediğiniz takdirde uygulamanız bloke edilecektir. \r\n\r\n"
                            . "Eğer ödemenizi gerçekleştirdiyseniz bu maili dikkate almayabilirsiniz. \r\n\r\n"
                            . "İyi çalışmalar.";
                        break;
                }

                $m->from(Config::get('custom.mail_email'), Config::get('custom.mail_displayname'));
                $m->to($user["email"]);
                $m->subject("Galepress Dijital Yayin Platformu Ödeme Hatırlatma Maili");
                $m->body($msg);
            });
        }
    }

    public static function sendPaymentAdminReminderMail($msg)
    {
        $adminMailSet = Config::get("custom.payment_delay_reminder_admin_mail_set");
        Bundle::start('messages');
        foreach ($adminMailSet as $adminMail) {
            Message::send(function ($m) use ($adminMail, $msg) {
                $m->from(Config::get('custom.mail_email'), Config::get('custom.mail_displayname'));
                $m->to($adminMail);
                $m->subject("Galepress Ödeme Hatırlatma Maili");
                $m->body($msg);
            });
        }
    }

    public static function sendStatusMail($msg)
    {
        $toEmailSet = Config::get('custom.admin_email_set');
        $subject = __('common.task_status');
        Log::info($msg);
        Bundle::start('messages');
        foreach ($toEmailSet as $toEmail) {
            Message::send(function ($m) use ($toEmail, $subject, $msg) {
                $m->from(Config::get('custom.mail_email'), Config::get('custom.mail_displayname'));
                $m->to($toEmail);
                $m->subject($subject);
                $m->body($msg);
            });
        }
    }

    public static function sendEmail($toEmail, $toDisplayName, $subject, $msg)
    {
        try {
            Message::send(function ($m) use ($toEmail, $toDisplayName, $subject, $msg) {
                $m->from(Config::get('custom.mail_email'), Config::get('custom.mail_displayname'));
                //$m->to($toEmail);
                $m->to($toEmail, $toDisplayName);
                $m->subject($subject);
                $m->body($msg);
                //$m->html(true);
            });
        } catch (Exception $e) {
            //return 'Mailer error: ' . $e->getMessage();
        }
    }

    public static function sendHtmlEmail($toEmail, $toDisplayName, $subject, $msg)
    {
        try {
            Bundle::start('messages');
            Message::send(function ($m) use ($toEmail, $toDisplayName, $subject, $msg) {
                $m->from(Config::get('custom.mail_email'), Config::get('custom.mail_displayname'));
                //$m->to($toEmail);
                $m->to($toEmail, $toDisplayName);
                $m->subject($subject);
                $m->body($msg);
                $m->html(true);
            });
            return true;
        } catch (Exception $e) {
            // return 'Mailer error: ' . $e->getMessage();
            return false;
        }
    }

    public static function generatePassword($length = 6, $level = 2)
    {
        list($usec, $sec) = explode(' ', microtime());
        srand((float)$sec + ((float)$usec * 100000));

        $validchars[1] = "0123456789abcdfghjkmnpqrstvwxyz";
        $validchars[2] = "0123456789abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $validchars[3] = "0123456789_!@#$%&*()-=+/abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_!@#$%&*()-=+/";

        $password = "";
        $counter = 0;

        while ($counter < $length) {
            $actChar = substr($validchars[$level], rand(0, strlen($validchars[$level]) - 1), 1);

            // All character must be different
            if (!strstr($password, $actChar)) {
                $password .= $actChar;
                $counter++;
            }
        }
        return $password;
    }

    public static function dateLocalize($format, $timestamp = 'time()')
    {
        return date($format, $timestamp);
    }

    public static function convert2Localzone($d, $write = false)
    {
        //2009-07-14 04:27:16
        if (Auth::check()) {
            $sign = '+';
            $hour = 0;
            $minute = 0;

            $timezone = Auth::User()->Timezone;
            $timezone = str_replace('UTC', '', $timezone);
            $timezone = preg_replace('/\s+/', '', $timezone);
            //var_dump($timezone);

            if (Str::length($timezone) > 0) {

                $sign = substr($timezone, 0, 1);
                $timezone = str_replace($sign, '', $timezone);
                $pos = strrpos($timezone, ":");
                if ($pos === false) {
                    //yok
                    $hour = (int)$timezone;
                } else {
                    //var
                    $segment = explode(":", $timezone);
                    $hour = (int)$segment[0];
                    $minute = (int)$segment[1];
                }
            }

            //var_dump($sign);
            //var_dump($hour);
            //var_dump($minute);
            //var_dump($d);

            if ($write) {
                if ($sign == '+') {
                    $sign = '-';
                } else {
                    $sign = '+';
                }
            }

            if ($hour > 0) {
                $date = new DateTime($d);
                $d = date("Y-m-d H:i:s", strtotime($sign . $hour . ' hours', $date->getTimestamp()));
            }

            if ($minute > 0) {
                $date = new DateTime($d);
                $d = date("Y-m-d H:i:s", strtotime($sign . $minute . ' minutes', $date->getTimestamp()));
            }
            //var_dump($d);
        }
        return $d;
    }

    public static function dateRead($date, $format, $useLocal = true)
    {
        if (empty($date)) {
            $date = date("Y-m-d");
        }
        $ret = "";
        if ($useLocal) {
            $date = Common::convert2Localzone($date);
        }
        if (Laravel\Config::get('application.language') == 'usa') {
            if ($format == 'd.m.Y') {
                $format = 'm/d/Y';
            } else if ($format == 'd.m.Y H:i') {
                $format = 'm/d/Y H:i';
            } else if ($format == 'd.m.Y H:i:s') {
                $format = 'm/d/Y H:i:s';
            }
        }
        return date($format, strtotime($date));
    }

    public static function dateWrite($date, $useLocal = true)
    {
        if (empty($date)) {
            $date = date("Y-m-d");
        }
        $ret = date('Y-m-d H:i:s', strtotime($date));
        if ($useLocal) {
            $ret = Common::convert2Localzone($ret, true);
        }
        return $ret;
    }

    public static function getFormattedData($data, $type)
    {
        $ret = "";
        //$FieldTypeVariant
        //Number
        //String
        //Percent
        //DateTime
        //Date
        //Bit
        if ($type == "Number") {
            $ret = $data;
        } elseif ($type == "String") {
            if (Common::startsWith($data, '!!!')) {
                $ret = __('common.' . str_replace('!!!', '', $data))->get();
            } else {
                $ret = $data;
            }
        } elseif ($type == "Percent") {
            $ret = '% ' . round((float)$data, 2);
        } elseif ($type == "DateTime") {
            $ret = Common::dateRead($data, "dd.MM.yyyy HH:mm");
        } elseif ($type == "Date") {
            $ret = Common::dateRead($data, "dd.MM.yyyy");
        } elseif ($type == "Bit") {
            $ret = ((int)$data == 1 ? "Evet" : "Hayır");
        } elseif ($type == "Size") {

            $size = (float)$data;
            $s = "Byte";

            if ($size > 1024) {

                $size = $size / 1024;
                $s = "KB";

                if ($size > 1024) {

                    $size = $size / 1024;
                    $s = "MB";

                    if ($size > 1024) {

                        $size = $size / 1024;
                        $s = "GB";

                        if ($size > 1024) {

                            $size = $size / 1024;
                            $s = "TB";
                        }
                    }
                }
            }
            $size = number_format($size, 2, '.', '');
            $ret = $size . " " . $s;
        } else {
            $ret = $data;
        }
        return $ret;
    }

    public static function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    public static function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            //return true;
            return false;
        }
        return (substr($haystack, -$length) === $needle);
    }

    public static function monthName($month)
    {
        $m = __('common.month_names')->get();
        return $m[$month];
    }

    public static function getLocationData($type, $customerID, $applicationID, $contentID, $country = '', $city = '')
    {
        $currentUser = Auth::User();

        $isCountry = false;
        $isCity = false;
        $isDistrict = false;
        $column = 'Country';

        if ($type == 'country') {
            $isCountry = true;
            $column = 'Country';
        } elseif ($type == 'city') {
            $isCity = true;
            $column = 'City';
        } elseif ($type == 'district') {
            $isDistrict = true;
            $column = 'District';
        }

        $rs = DB::table('Statistic')
            ->where(function ($query) use ($currentUser, $isCountry, $isCity, $isDistrict, $customerID, $applicationID, $contentID, $country, $city) {
                if ((int)$currentUser->UserTypeID == eUserTypes::Manager && $customerID > 0) {
                    $query->where('CustomerID', '=', $customerID);
                } elseif ((int)$currentUser->UserTypeID == eUserTypes::Customer) {
                    $query->where('CustomerID', '=', $currentUser->CustomerID);
                }

                if ($applicationID > 0) {
                    if (Common::CheckApplicationOwnership($applicationID)) {
                        $query->where('ApplicationID', '=', $applicationID);
                    }
                }

                if ($contentID > 0) {
                    if (Common::CheckContentOwnership($contentID)) {
                        $query->where('ContentID', '=', $contentID);
                    }
                }

                if ($isCity) {
                    $query->where('Country', '=', (strlen($country) > 0 ? $country : '???'));
                } elseif ($isDistrict) {
                    $query->where('Country', '=', (strlen($country) > 0 ? $country : '???'));
                    $query->where('City', '=', (strlen($city) > 0 ? $city : '???'));
                }
            })
            ->distinct()
            ->order_by($column, 'ASC')
            ->get($column);

        return $rs;
    }

    public static function toExcel($twoDimensionalArray, $toFile)
    {
        $rows = array();
        $sep = "\t";
        foreach ($twoDimensionalArray as $row) {
            $tmpStr = "";
            foreach ($row as $cell) {
                $r = "";
                if ($cell != "") {
                    $r .= "$cell" . $sep;
                } else {
                    $r .= "" . $sep;
                }
                $tmpStr .= $r;
            }

            $tmpStr1 = str_replace($sep . "$", "", $tmpStr);
            $tmpStr2 = preg_replace("/\r\n|\n\r|\n|\r/", " ", $tmpStr1);
            $tmpStr2 .= "\t";
            $tmpStr3 = trim($tmpStr2);
            $tmpStr3 .= "\n";

            $rows[] = $tmpStr3;
        }

        $rows[] = "\n";
        $result = implode("", $rows);
        $finalResult = chr(255) . chr(254) . iconv("UTF-8", "UTF-16LE//IGNORE", $result);
        $fileHandle = fopen($toFile, "w");
        fwrite($fileHandle, $finalResult);
        fclose($fileHandle);
    }

    public static function getPostDataString($postData)
    {
        $postDataString = "";
        foreach ($postData as $key => $value) {
            if (empty($postDataString)) {
                $postDataString .= $key . "=" . $value;
            } else {
                $postDataString .= '&' . $key . "=" . $value;
            }
        }
        return $postDataString;
    }

    public static function localize($key, $replacements = array(), $language = null)
    {
        $result = Laravel\Lang::line(Laravel\Request::$route->controller . '.' . $key, $replacements, $language);
        if (empty($result)) {
            $result = $key;
        }
        return $result;
    }

    public static function moneyFormat($inputName)
    {
        return str_replace(",", ".", str_replace(".", "", Input::get($inputName)));
    }

}
