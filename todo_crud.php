<?php 
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "todo_list";

$conn = mysqli_connect($host, $usuario, $senha, $banco);
if($conn->connect_error)
{
    die("Falaha na conexção com o banco de dados ". $conn->connect_error);
     
}

if($_SERVER ['REQUEST_METHOD'] === "POST" && isset($_POST["descricao"]))
    {
        $descricao = $conn->real_escape_string($_POST['descricao']);
        $sqlInsert = "INSERT INTO tarefas (descricao) VALUES ('$descricao')";

        if($conn->query($sqlInsert) === TRUE)
    {
        header("Location: todo_crud.php");
        exit;
    }

    }
    

if(isset($_GET['delete']))
{
    $id = intval($_GET['delete']);
    $sqlDelete = "DELETE FROM tarefas WHERE id = $id";

    if($conn->query($sqlDelete) === TRUE)
    {
         header("Location: todo_crud.php");
        exit;
    }

}

$tarefas = [];


$sqlSelect = "SELECT * FROM tarefas ORDER BY criacao DESC";
$result = $conn ->query($sqlSelect);

if($result->num_rows > 0)
{
    while($row = $result -> fetch_assoc())
        $tarefas[] = $row;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo list</title>
    <link rel="stylesheet" href="style.css">



</head>
<body>
    <form action="todo_crud.php" method="POST">
        <input type="text" placeholder="Discrição da Tarefa" name="descricao" required>
        <button type="submit">Adicionar</button>
    </form>
    
    <h2>Suas Tarefas</h2>
    <?php if(!empty($tarefas)): ?>
        <ul>
            <?php foreach($tarefas as $tarefa): ?>
                <li>
                    <?php echo $tarefa['descricao'];?>
                    <a href ="todo_crud.php?delete=<?php echo $tarefa['id'] ?>">Excluir</a>
                </li>
          <?php endforeach;?>
        </ul>
        <?php else :?>
            <h1>Não a Tarefas.</h1>
        <?php endif;?>


</body>
</html>