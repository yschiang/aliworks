<html>
   <head>
      <meta charset="utf-8">
      <title>Simple Web App</title>
      <link rel="stylesheet" type="text/css" href="css/style.css">
   </head>
   <body>
      <img width="400" src="http://resources.johnsonchiang.com/banner.png" referrerpolicy="origin"/>
      <p class="hostedby">Hosted by <?=$_SERVER['SERVER_ADDR']; ?></p>
<?php

/**
 * Function to query information based on
 * a parameter: in this case, location.
 *
 */

if (isset($_POST['submit']))
{

        try
        {

                require "../config.php";
                require "../common.php";

                $connection = new PDO($dsn, $username, $password, $options);

                $sql = "SELECT *
                                                FROM users
                                                WHERE location = :location";

                $location = $_POST['location'];

                $statement = $connection->prepare($sql);
                $statement->bindParam(':location', $location, PDO::PARAM_STR);
                $statement->execute();

                $result = $statement->fetchAll();
        }

        catch(PDOException $error)
        {
                echo $sql . "<br>" . $error->getMessage();
        }
}
?>

<?php
if (isset($_POST['submit']))
{
        if ($result && $statement->rowCount() > 0)
        { ?>
      <h2>使用者搜尋讀取結果</h2>
      <table>
         <tr>
            <th>#</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Age</th>
            <th>Location</th>
            <th>Date</th>
         </tr>
        <?php
                foreach ($result as $row)
                { ?>
                        <tr>
                                <td><?php echo escape($row["id"]); ?></td>
                                <td><?php echo escape($row["firstname"]); ?></td>
                                <td><?php echo escape($row["lastname"]); ?></td>
                                <td><?php echo escape($row["email"]); ?></td>
                                <td><?php echo escape($row["age"]); ?></td>
                                <td><?php echo escape($row["location"]); ?></td>
                                <td><?php echo escape($row["date"]); ?> </td>
                        </tr>
                <?php
                } ?>
        </table>
        <?php
        }
        else
        { ?>
                <blockquote>搜尋不到紀錄<?php echo escape($_POST['location']); ?></blockquote>
        <?php
        }
}?>
      <h2>根據Location (TPE, HK）搜尋使用者</h2>
      <form method="post" class="form-style">
         <ul>
            <li>
               <label for="location">Location</label>
               <input type="text" id="location" name="location">
               <span>輸入地點，例：HK, TPE, BJ, SH</span>
            </li>
            <li>
               <input type="submit" name="submit" value="搜尋">
               <a class="link-btn" href="index.html">返回首頁</a>
            </li>
         </ul>
      </form>
   </body>
</html>
