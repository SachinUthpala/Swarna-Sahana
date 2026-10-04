<?php

require_once '../Db.conn.php';
session_start();

if (isset($_POST['dailyBuisness'])) {

    // Get POST values
    $date = $_POST['Date'] ?? '';
    $time = $_POST['Time'] ?? '';
    $count = (int)($_POST['BuyingPrice'] ?? 0);
    $campingType = (int)($_POST['boardcampingType'] ?? 0);
    $boardcampingUser = $_POST['boardcampingUser'] ?? '';
    $boardcampingLocations = $_POST['campinglocation'] ?? '';


    /*
    |--------------------------------------------------------------------------
    | Validate Data
    |--------------------------------------------------------------------------
    */

    if (
        empty($date) ||
        empty($time) ||
        empty($boardcampingUser) ||
        empty($boardcampingLocations) ||
        $count <= 0
    ) {

        $_SESSION['TaskCreated'] = 0;

        header("Location: ../../AdminPanel/CreateDailyBoardCamping.php");
        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | Calculate Amount
    |--------------------------------------------------------------------------
    */

    if ($campingType == 1) {

        // Camping type 1 = Rs. 10 per count
        $finalAmount = $count * 10;

    } elseif ($campingType == 2) {

        // Camping type 2 = Rs. 15 per count
        $finalAmount = $count * 15;

    } else {

        $_SESSION['TaskCreated'] = 0;

        header("Location: ../../AdminPanel/CreateDailyBoardCamping.php");
        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | Insert Camping Location
    |--------------------------------------------------------------------------
    */

    $sqlLocation = "
        INSERT INTO boardcampinglocations
        (
            location,
            count,
            date,
            time,
            createduser,
            ridingtype
        )
        VALUES (?, ?, ?, ?, ?, ?)
    ";

    $locationStmt = mysqli_prepare($conn, $sqlLocation);

    if (!$locationStmt) {

        $_SESSION['TaskCreated'] = 0;

        header("Location: ../../AdminPanel/CreateDailyBoardCamping.php");
        exit;
    }


    /*
     * s = string
     * i = integer
     * s = string
     * s = string
     * s = string
     */

    mysqli_stmt_bind_param(
        $locationStmt,
        "sisssi",
        $boardcampingLocations,
        $count,
        $date,
        $time,
        $boardcampingUser,
        $campingType
    );


    // Execute location insert
    if (!mysqli_stmt_execute($locationStmt)) {

        mysqli_stmt_close($locationStmt);

        $_SESSION['TaskCreated'] = 0;

        header("Location: ../../AdminPanel/CreateDailyBoardCamping.php");
        exit;
    }

    mysqli_stmt_close($locationStmt);


    /*
    |--------------------------------------------------------------------------
    | Check Existing Record
    |--------------------------------------------------------------------------
    */

    $sql = "
        SELECT costId, count, amount
        FROM bordcampingcost
        WHERE boardcampingUser = ?
        AND date = ?
    ";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {

        $_SESSION['TaskCreated'] = 0;

        header("Location: ../../AdminPanel/CreateDailyBoardCamping.php");
        exit;
    }


    mysqli_stmt_bind_param(
        $stmt,
        "ss",
        $boardcampingUser,
        $date
    );


    // Execute SELECT
    if (!mysqli_stmt_execute($stmt)) {

        mysqli_stmt_close($stmt);

        $_SESSION['TaskCreated'] = 0;

        header("Location: ../../AdminPanel/CreateDailyBoardCamping.php");
        exit;
    }


    $result = mysqli_stmt_get_result($stmt);


    /*
    |--------------------------------------------------------------------------
    | Existing Record Found
    |--------------------------------------------------------------------------
    */

    if ($result && mysqli_num_rows($result) > 0) {

        $existingRecord = mysqli_fetch_assoc($result);

        $existingCount = (int)$existingRecord['count'];
        $existingAmount = (float)$existingRecord['amount'];
        $costId = (int)$existingRecord['costId'];

        // Calculate new values
        $newCount = $existingCount + $count;
        $newAmount = $existingAmount + $finalAmount;


        mysqli_stmt_close($stmt);


        /*
        |--------------------------------------------------------------------------
        | Update Existing Record
        |--------------------------------------------------------------------------
        */

        $updateSql = "
            UPDATE bordcampingcost
            SET
                time = ?,
                count = ?,
                amount = ?
            WHERE costId = ?
        ";

        $updateStmt = mysqli_prepare($conn, $updateSql);

        if (!$updateStmt) {

            $_SESSION['TaskCreated'] = 0;

            header("Location: ../../AdminPanel/CreateDailyBoardCamping.php");
            exit;
        }


        /*
         * s = time
         * i = count
         * d = amount
         * i = costId
         */

        mysqli_stmt_bind_param(
            $updateStmt,
            "sidi",
            $time,
            $newCount,
            $newAmount,
            $costId
        );


        // Execute update
        if (mysqli_stmt_execute($updateStmt)) {

            mysqli_stmt_close($updateStmt);

            $_SESSION['TaskCreated'] = 1;

            header("Location: ../../AdminPanel/CreateDailyBoardCamping.php");
            exit;

        } else {

            mysqli_stmt_close($updateStmt);

            $_SESSION['TaskCreated'] = 0;

            header("Location: ../../AdminPanel/CreateDailyBoardCamping.php");
            exit;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | No Existing Record - Insert New Record
    |--------------------------------------------------------------------------
    */

    mysqli_stmt_close($stmt);


    $insertSql = "
        INSERT INTO bordcampingcost
        (
            date,
            time,
            boardcampingUser,
            count,
            amount,
            paidAmount
        )
        VALUES (?, ?, ?, ?, ?, 0)
    ";


    $insertStmt = mysqli_prepare($conn, $insertSql);

    if (!$insertStmt) {

        $_SESSION['TaskCreated'] = 0;

        header("Location: ../../AdminPanel/CreateDailyBoardCamping.php");
        exit;
    }


    /*
     * s = date
     * s = time
     * s = boardcampingUser
     * i = count
     * d = finalAmount
     */

    mysqli_stmt_bind_param(
        $insertStmt,
        "sssid",
        $date,
        $time,
        $boardcampingUser,
        $count,
        $finalAmount
    );


    /*
    |--------------------------------------------------------------------------
    | Execute Insert
    |--------------------------------------------------------------------------
    */

    if (mysqli_stmt_execute($insertStmt)) {

        mysqli_stmt_close($insertStmt);

        $_SESSION['TaskCreated'] = 1;

        header("Location: ../../AdminPanel/CreateDailyBoardCamping.php");
        exit;

    } else {

        mysqli_stmt_close($insertStmt);

        $_SESSION['TaskCreated'] = 0;

        header("Location: ../../AdminPanel/CreateDailyBoardCamping.php");
        exit;
    }
}

?>