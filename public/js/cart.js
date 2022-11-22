$(document).ready(function() {
    // minus btn click
    $('.btn-minus').click(function() {
        $parentNode = $(this).parents('tr');

        countCalculation();
        summaryCalculation();
    })

    // plus btn click
    $('.btn-plus').click(function() {
        $parentNode = $(this).parents('tr');

        countCalculation();
        summaryCalculation();
    })

    // increment decrement
    function countCalculation() {
        $price = Number($parentNode.find('#price').text().replace("kyats", "")); // value ma hote tae hr twy
        // $price = $parentNode.find('#price').val(); // input mhr value nat call yin use

        $qty = Number($parentNode.find('#qty').val());
        // $qty =($parentNode.find('#qty').val()*1);

        $total = $price * $qty;
        $parentNode.find('#total').html($total + " kyats")
    }

    // total summary
    function summaryCalculation() {
        $summaryTotal = 0;
        $('#dataTable tbody tr').each(function(index, row) {
            $summaryTotal += Number($(row).find('#total').text().replace("kyats", ""));
        })

        $("#subTotalPrice").html(`${$summaryTotal} kyats`);
        $("#finalPrice").html(`${$summaryTotal+3000} kyats`);
    }
})