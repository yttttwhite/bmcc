namespace java com.bcdata.sms

service SendService
{
    void send(1:list<string> mobiles, 2:string content); 
}
