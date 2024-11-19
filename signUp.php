<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Steel And Stones</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="css/styles.css">
    <script src="js/signUp.js"></script>
</head>
<body>
    <?php
        if (isset($_GET['message'])) {
            if ($_GET['message'] == "verifyMail") {
                echo '
                    <div class="modal fade show d-block" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="background-color: rgba(0, 0, 0, 0.5);">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Verification mail is sent to your email. Please verify your email!
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        // Automatically display the modal
                        var myModal = new bootstrap.Modal(document.getElementById("exampleModal"), {});
                        myModal.show();

                        history.replaceState(null, null, window.location.pathname);
                    </script>
                ';
            }
        }
    ?>
    <div class="row g-0">
        <div class="col-lg-6 col-md-8 col-12-sm vh-100 d-flex flex-column justify-content-center align-items-center">
            <div class="d-flex flex-column justify-content-center align-items-center gap-3">
                <div class="d-flex justify-content-center align-items-center gap-4">
                    <img src="files/logo-no-background 2.png" alt="logo" class="w-100 object-fit-contain ">
                    <p class="heading32600">Create&nbsp;Account</p>
                </div>
                <form action="signUpForm.php" id="signUpForm" method="POST">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control form-input shadow-none">
                
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" class="form-control form-input shadow-none">
                
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control form-input shadow-none">
                    <div id="passwordHints">
                        <ul id="passwordHint"> 
                            <li><p class="nok" id="numOfChar">Should contain 8 characters</p></li>
                            <li><p class="nok" id="num">Should contain a number</p></li>
                            <li><p class="nok" id="ucase">Should contain an uppercase letter</p></li>
                            <li><p class="nok" id="lcase">Should contain a lowercase letter</p></li>
                        </ul>
                    </div>

                    <label for="confirmpass">Confirm Password</label>
                    <input type="password" id="confirmpass" name="confirmpass" class="form-control form-input shadow-none">
                
                    <label for="submitBtn" class="d-none">Submit</label>
                    <input type="submit" id="submitBtn" name="submitBtn" class="btn btn-login">
                </form>
                
                <div class="aboveSocial row justify-content-center align-items-center w-100">
                    <div class="line col-3"></div>
                    <div id="text" class="col-6">Or Continue With</div>
                    <div class="line col-3"></div>
                </div>

                <?php
                    require_once 'config.php';
                    include 'connect.php';

                    if (isset($_SESSION['userID'])) {
                        header("Location: index.html");
                    } else {
                        if (isset($_GET['code'])) {
                            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
                            $client->setAccessToken($token['access_token']);

                            $google_oauth = new Google_Service_Oauth2($client);
                            $google_account_info = $google_oauth->userinfo->get();
                            $userinfo = [
                                'email' => $google_account_info['email'],
                                'full_name' => $google_account_info['name'],
                                'picture' => $google_account_info['picture'],
                                'token' => $google_account_info['id'],
                            ];
                            $email = $userinfo['email'];

                            $sql = "SELECT * FROM users WHERE email = ? AND googleLogin = 1";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param('s', $email);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                $user = $result->fetch_assoc();
                                session_start();
                                $_SESSION['userID'] = $user['userID'];
                                header("Location: index.html");
                                exit();
                            } else {
                                $checkNormalLogin = "SELECT * FROM users WHERE email = ? AND googleLogin = 0";
                                $stmt = $conn->prepare($checkNormalLogin);
                                $stmt->bind_param('s', $email);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if ($result->num_rows > 0) {
                                    $updateQuery = "UPDATE users 
                                                    SET username = ?, profilePic = ?, password = ?, googleLogin = 1 
                                                    WHERE email = ? AND googleLogin = 0";
                                    $updateStmt = $conn->prepare($updateQuery);
                                    $updateStmt->bind_param(
                                        'ssss',
                                        $userinfo['full_name'],
                                        $userinfo['picture'],
                                        $userinfo['token'],
                                        $email
                                    );

                                    if ($updateStmt->execute()) {
                                        $user = $result->fetch_assoc();
                                        session_start();
                                        $_SESSION['userID'] = $user['userID'];
                                        header("Location: index.html");
                                        exit();
                                    } else {
                                        echo "Error updating user: " . $conn->error;
                                    }
                                } else {
                                    $sql = "INSERT INTO users (username, profilePic, email, password, googleLogin) 
                                            VALUES (?, ?, ?, ?, 1)";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bind_param(
                                        'ssss',
                                        $userinfo['full_name'],
                                        $userinfo['picture'],
                                        $userinfo['email'],
                                        $userinfo['token']
                                    );

                                    if ($stmt->execute()) {
                                        $newUserID = $conn->insert_id;
                                        session_start();
                                        $_SESSION['userID'] = $newUserID;
                                        header("Location: index.html");
                                        exit();
                                    } else {
                                        echo "Error creating user!";
                                    }
                                }
                            }
                        } else {
                            echo "<a href='" . $client->createAuthUrl() . "'><img src='files/google.png' alt='' class='socialIcon'></a>";
                        }
                    }
                ?>
                
                <p class="px12">Have an account? <span class="link"><a href="signIn.html">Sign In</a></span></p>
            </div>
        </div>
        <div class="col-lg-6 col-md-4 d-none d-lg-block d-md-block">
            <img src="files/signInImage.png" alt="signInImage" class="object-fit-cover vh-100 w-100">
        </div>
    </div>
    <div id="liveAlertPlaceholder"></div>
</body>
</html>