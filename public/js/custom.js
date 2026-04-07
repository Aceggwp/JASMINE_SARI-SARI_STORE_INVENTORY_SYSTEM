$(document).ready(function() {
    // Initialize DataTables
    if ($('.datatable').length) {
        $('.datatable').DataTable({
            responsive: true,
            language: {
                search: "Search:",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries"
            }
        });
    }
    
    // Auto-hide alerts after 3 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 3000);
    
    // Stock adjustment form validation
    $('#stock-form').on('submit', function(e) {
        const quantity = parseInt($('#quantity').val());
        if (isNaN(quantity) || quantity <= 0) {
            e.preventDefault();
            alert('Please enter a valid quantity');
            return false;
        }
    });
});

// AJAX function to get product details
function getProductDetails(productId) {
    $.ajax({
        url: baseUrl + '/api/get-product/' + productId,
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.success) {
                $('#product_price').val(data.product.price);
                $('#current_stock').val(data.product.quantity);
                $('#product_name').val(data.product.name);
            }
        }
    });
}