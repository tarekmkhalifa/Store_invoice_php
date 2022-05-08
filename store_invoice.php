<?php
$cityy = ['', 'Cairo', 'Giza', 'Alex', 'Other'];
if (!empty($_POST['showproducts'])) {
    $table = "<form method='post'>
    <input type='hidden' name='name' value='" . $_POST['name'] . "'>
    <input type='hidden' name='city' value='" . $_POST['city'] . "'>
    <table class='table'>
    <thead class='thead'>
        <tr>
            <th>Product Name</th>
            <th>Price</th>
            <th>Quantity</th>
        </tr>
    </thead>
    <tbody>";


    if (isset($_POST['productsnumber']))
        for ($i = 0; $i < $_POST['productsnumber']; $i++) {

            $table .= "<tr>
            <td><input type='text' name='product[]'></td> 
            <td><input type='number' name='price[]'></td>
            <td><input type='number' name='quantity[]'></td>";
        }

    $table .= "</tr></tbody></table>";

    $button = "<div class='col-12'>
<input type='submit' name='productscalc' class='form-control btn btn-primary' value='Calculate'>
</div>
</form>
<a class='back' href='index.php'>Back</a>";
}
if (!empty($_POST['productscalc'])) {
    if (isset($_POST['productscalc'])) {

        $table2 = "<table class='table text-center'>
    <thead>
      <tr>
        <th scope='col'>Product Name</th>
        <th scope='col'>Price</th>
        <th scope='col'>Quantity</th>
        <th scope='col'>Sub Total</th>
      </tr>
    </thead>
    <tbody>";
        for ($i = 0; $i < count($_POST['product']) && $i < count($_POST['price']) && $i < count($_POST['quantity']); $i++) {
            $table2 .= "<tr><td>" . $_POST['product'][$i] . "</td>";
            $table2 .= "<td>" . $_POST['price'][$i] . "</td>";
            $table2 .= "<td>" . $_POST['quantity'][$i] . "</td>";
            $table2 .= "<td>" . $_POST['quantity'][$i] * $_POST['price'][$i] . "</td>";
            $total[$i] = $_POST['quantity'][$i] * $_POST['price'][$i];
        }
        $total = array_sum($total);

        function allowDiscount($total)
        {
            if ($total < 1000) {
                $disc = 0;
            } elseif ($total < 3000) {
                $disc = 0.10;
            } elseif ($total < 4500) {
                $disc = 0.15;
            } elseif ($total > 4500) {
                $disc = 0.20;
            }
            $disValue = $disc * $total;
            return $disValue;
        }

        function TotalAfterDisc($disValue)
        {
        }

        $disValue = allowDiscount($total);

        $TotalAfterDisc = $total - $disValue;
        $city = $_POST['city'];
        function DeliveryFees($city)
        {
            if ($city == 'Cairo') {
                $delivery = 0;
                return $delivery;
            } elseif ($city == 'Giza') {
                $delivery = 30;
                return $delivery;
            } elseif ($city == 'Alex') {
                $delivery = 50;
                return $delivery;
            } elseif ($city == 'Other') {
                $delivery = 100;
                return $delivery;
            }
        }

        $DeliveryFees = DeliveryFees($city);

        $NetTotal = $TotalAfterDisc + $DeliveryFees;

        $table2 .= "</tr><tr>
                    <th>Client Name</th>
                    <td>" . $_POST['name'] . "</td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <th>City</th>
                    <td>" . $_POST['city'] . "</td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <th>Total</th>
                    <td>" . $total . "</td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <th>Discount Value</th>
                    <td>" . $disValue . "</td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <th>Total After Discount</th>
                    <td>" . $TotalAfterDisc . "</td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <th>Delivery Fees</th>
                    <td>" . $DeliveryFees . "</td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <th>Net Total</th>
                    <td>" . $NetTotal . "</td>
                    <td></td>
                    <td></td>
                </tr>
                 </tbody>
                </table>
                <a class='back' href='index.php'>Back</a>";
    }
}


?>

<!doctype html>
<html lang="en">

<head>
    <title>Store Market</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        .back {
            display: inline-block;
            padding: 5px 10px;
            background-color: #2a6cf4;
            color: white;
            text-decoration: none;
            text-transform: uppercase;
            margin: 70px 20px;
        }

        .back:hover {
            text-decoration: none;
            color: white;
            opacity: 0.8;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row my-5">
            <div class="col-8 offset-2">
                <form method="post" >
                    <div class="row">
                        <div class="col-12">
                            <input type="text" name="name" value="<?php echo (isset($_POST['name']) ? $_POST['name'] : '') ?>" class="form-control" placeholder="Customer Name">
                        </div>
                        <div class="col-12">
                            <label class="form-control">City:</label>
                        </div>
                        <div class="col-12">
                            <select class="form-control" name="city">
                                <?php
                                foreach ($cityy as $key => $value) {
                                ?>
                                    <option value="<?php echo $value; ?>"> <?php echo $value;
                                                                        } ?> </option>
                            </select>
                        </div>
                        <div class="col-12">
                            <input type="number" name="productsnumber" class="form-control" placeholder="Number of Products" value="<?php if(isset($_POST['productsnumber'])) { echo $_POST['productsnumber'];} ?>">
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" name="showproducts" class="form-control btn btn-primary" value="showproducts">Enter Products</button>
                        </div>

                    </div>
                </form>
            </div>
            <div class="col-8 offset-2">
                <?php echo isset($table) ? $table : ''; ?>
                <?php echo isset($button) ? $button : ''; ?>
                <?php echo isset($table2) ? $table2  : ''; ?>
            </div>



            <!-- Optional JavaScript -->
            <!-- jQuery first, then Popper.js, then Bootstrap JS -->
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        </div>
    </div>
</body>

</html>