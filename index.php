<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP CRUD</title>
    <!-- Bootstrap 4 (comme dans votre version originale) -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <?php
        session_start();
        require_once 'config.php';
        
        // Initialisation des variables pour l'édition
        $name = '';
        $location = '';
        $edit_state = false;
        $id = 0;

        if (isset($_GET['edit'])) {
            $id = $_GET['edit'];
            $stmt = $mysqli->prepare("SELECT * FROM data WHERE id=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $name = $row['name'];
                $location = $row['location'];
                $edit_state = true;
            }
            $stmt->close();
        }
        ?>

        <!-- Message de session (identique à l'original) -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?=$_SESSION['msg_type']?>">
                <?=$_SESSION['message']?>
                <?php unset($_SESSION['message'], $_SESSION['msg_type']); ?>
            </div>
        <?php endif; ?>

        <!-- Tableau (identique à l'original) -->
        <div class="row justify-content-center">
            <table class="table">
                <h2>Records</h2>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Location</th>
                        <th colspan="2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = $mysqli->query("SELECT * FROM data") or die($mysqli->error);
                    while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?=htmlspecialchars($row['name'])?></td>
                            <td><?=htmlspecialchars($row['location'])?></td>
                            <td>
                                <a href="index.php?edit=<?=$row['id']?>" class="btn btn-info">Edit</a>
                                <a href="process.php?delete=<?=$row['id']?>" 
                                   class="btn btn-danger" 
                                   onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Formulaire (identique à l'original) -->
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="process.php" method="POST">
                    <input type="hidden" name="id" value="<?=$id?>">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" 
                               value="<?=htmlspecialchars($name)?>" required>
                    </div>
                    <div class="form-group">
                        <label>Location</label>
                        <input type="text" class="form-control" name="location" 
                               value="<?=htmlspecialchars($location)?>" required>
                    </div>
                    <div class="form-group">
                        <?php if ($edit_state): ?>
                            <button type="submit" name="update" class="btn btn-info">Update</button>
                        <?php else: ?>
                            <button type="submit" name="save" class="btn btn-primary">Save</button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JS Bootstrap 4 (identique à l'original) -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>