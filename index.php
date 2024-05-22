<?php
// Inventory data
$inventory = array(
    array("id" => 1, "name" => "Item A", "price" => 10.00, "weight" => 1.0),
    array("id" => 2, "name" => "Item B", "price" => 15.00, "weight" => 1.5),
    array("id" => 3, "name" => "Item C", "price" => 20.00, "weight" => 2.0),
    array("id" => 4, "name" => "Item D", "price" => 25.00, "weight" => 2.5),
    array("id" => 5, "name" => "Item E", "price" => 30.00, "weight" => 3.0),
    array("id" => 6, "name" => "Item F", "price" => 35.00, "weight" => 3.5),
    array("id" => 7, "name" => "Item G", "price" => 40.00, "weight" => 4.0),
    array("id" => 8, "name" => "Item H", "price" => 45.00, "weight" => 4.5),
    array("id" => 9, "name" => "Item I", "price" => 50.00, "weight" => 5.0),
    array("id" => 10, "name" => "Item J", "price" => 55.00, "weight" => 5.5),
    array("id" => 11, "name" => "Item K", "price" => 60.00, "weight" => 6.0),
    array("id" => 12, "name" => "Item L", "price" => 65.00, "weight" => 6.5)
);

// Shipping rates data (example values, should be realistic based on distance)
$shipping_rates = array(
    "USA" => 5.00,
    "Canada" => 10.00,
    "UK" => 15.00,
    "Germany" => 15.00,
    "Australia" => 20.00,
    "Japan" => 25.00,
    "Other" => 30.00
);

function display_inventory($inventory) {
    echo "Available Items:\n";
    foreach ($inventory as $item) {
        echo "{$item['id']}. {$item['name']} - \${$item['price']} - {$item['weight']}kg\n";
    }
}

function get_user_selection($inventory) {
    $selected_items = array();
    while (true) {
        $item_id = readline("Enter the ID of the item you want to buy (0 to finish): ");
        if ($item_id == 0) {
            break;
        }
        $quantity = readline("Enter the quantity for item $item_id: ");
        $selected_items[] = array("id" => $item_id, "quantity" => $quantity);
    }
    return $selected_items;
}

function get_destination() {
    $destination = readline("Enter the destination country: ");
    return $destination;
}

function compute_subtotal($selected_items, $inventory) {
    $subtotal = 0.0;
    $total_weight = 0.0;
    foreach ($selected_items as $selected_item) {
        foreach ($inventory as $item) {
            if ($item["id"] == $selected_item["id"]) {
                $subtotal += $item["price"] * $selected_item["quantity"];
                $total_weight += $item["weight"] * $selected_item["quantity"];
                break;
            }
        }
    }
    return array($subtotal, $total_weight);
}

function compute_shipping_fee($total_weight, $destination, $shipping_rates) {
    $base_rate = isset($shipping_rates[$destination]) ? $shipping_rates[$destination] : $shipping_rates["Other"];
    $shipping_fee = $base_rate * $total_weight;
    return $shipping_fee;
}

function main() {
    global $inventory, $shipping_rates;
    display_inventory($inventory);
    $selected_items = get_user_selection($inventory);
    $destination = get_destination();
    list($subtotal, $total_weight) = compute_subtotal($selected_items, $inventory);
    $shipping_fee = compute_shipping_fee($total_weight, $destination, $shipping_rates);

    echo "\nSummary:\n";
    echo "Subtotal: \${$subtotal}\n";
    echo "Shipping Fee: \${$shipping_fee}\n";
    echo "Total: \${$subtotal + $shipping_fee}\n";
    $confirmation = readline("Do you want to complete the transaction? (yes/no): ");
    if (strtolower($confirmation) == 'yes') {
        echo "Transaction completed.\n";
    } else {
        echo "Transaction canceled.\n";
    }
}

main();
?>
