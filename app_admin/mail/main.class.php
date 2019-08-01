<?php


class mail_main extends SMail{
    private $isConfigMail = false;

    private $defaultConfig = array('Port' => 25, 'SMTPAuth' => true);

    public function __construct(){
        $MailNoticeConfig = SConfig::getConfigArray(ROOT_CONFIG."/mail.php" );
        if( !is_array($MailNoticeConfig) || empty($MailNoticeConfig) ) return;

        $MailNoticeConfig = array_merge($this->defaultConfig, $MailNoticeConfig);
        foreach ($MailNoticeConfig as $key => $value) {
            $this->set($key, $value);
        }
        $this->set('From', $MailNoticeConfig['Username']);
        $this->IsSMTP();
        $this->isConfigMail = true;
    }

    public function send() {
        if(!$this->isConfigMail){
            $this->ErrorInfo = "not config email";
            return false;
        }
        return parent::send();
    }
    
}
