
function encryptFormData(){
    var receiveData = document.getElementById('data').value;
    var datas = receiveData.split(":");

    var rsakey = new RSAKey();
    rsakey.setPublic(datas[0], datas[1]);

    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;

    var unEncrypt = rsakey.encrypt(username);
    var pwEncryption = rsakey.encrypt(password);

    document.getElementById('username').disabled=true;
    document.getElementById('password').disabled=true;

    document.getElementById('encrypted_username').value=unEncrypt;
    document.getElementById('encrypted_password').value=pwEncryption;
};