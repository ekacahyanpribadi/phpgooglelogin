<?php
// Include file gpconfig
include_once 'gpconfig.php';
include_once 'lib.start.php';



if(isset($_GET['code'])){
  $gclient->authenticate($_GET['code']);
  $_SESSION['token'] = $gclient->getAccessToken();
  header('Location: ' . filter_var($redirect_url, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['token'])) {
  $gclient->setAccessToken($_SESSION['token']);
}

if ($gclient->getAccessToken()) {
  

  // Get user profile data from google
  $gpuserprofile = $google_oauthv2->userinfo->get();
  
  //print_r($gpuserprofile); die();


  $email = $gpuserprofile['email']; // Ambil email Akun Google nya
  $first_name = $gpuserprofile['given_name'];
  $last_name = $gpuserprofile['family_name'];
  $picture = $gpuserprofile['picture'];
  $gender = "";
  $locale = "";


  $sql="SELECT id, email, first_name, last_name, picture FROM production.gusers WHERE email='$email'";
 // echo $sql; die();
  $user = DB::queryFirstRow($sql);
  //print_r($user); die();

	if(empty($user)){ // Jika User dengan email tersebut belum ada
		// Ambil username dari kata sebelum simbol @ pada email
		$ex = explode('@', $email); // Pisahkan berdasarkan "@"
		$username = $ex[0]; // Ambil kata pertama
        $id= getPk();
        $oauth_uid=$_SESSION['token'];

		// Lakukan insert data user baru tanpa password
        $sqlInsUser="
        insert into `production`.`gusers` values
        (
            '$id',
            'google',
            '$oauth_uid',
            '$first_name',
            '$last_name',
            '$email',
            '$gender',
            '$locale',
            '$picture',
            now(),
            '(NULL)'
        );
        ";
        $user = DB::queryFirstRow($sqlInsUser);

		$id = mysqli_insert_id($connect); // Ambil id user yang baru saja di insert
	}else{
		$id = $user['id']; // Ambil id pada tabel user
		$emaildb = $user['email']; // Ambil username pada tabel user
        $ex = explode('@', $emaildb); // Pisahkan berdasarkan "@"
		$username = $ex[0];
		$nama = $user['first_name']." ".$user['last_name']; // Ambil username pada tabel user
        $picture = $user['picture'];
	}

	$_SESSION['id'] = $id;
	$_SESSION['username'] = $username;
	$_SESSION['nama'] = $nama;
    $_SESSION['email'] = $email;
    $_SESSION['picture'] = $picture;

    header("location: ../welcome.php");
} else {
	$authUrl = $gclient->createAuthUrl();
	header("location: ".$authUrl);
}
?>


