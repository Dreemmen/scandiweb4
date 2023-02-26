$('document').ready(() => {
    $('#mass_delete_btn').click(() => {
        let prods_to_delete = [];
        $('#product_list').find('input[type="checkbox"]').each((index, element ) => {
                if(element.checked){
                    prods_to_delete.push(element.value);
                }
        });
        $.post('/delete', {to_delete: prods_to_delete}).done(function(response){
            window.location.href = "/";
        });
        /*
        $.ajax({
            url: '/actions/delete.php',
            method: 'POST',
            body: prods_to_delete
        });
    */
    });
});

const { createApp } = Vue;

createApp({
    data() {
        return {
            selected: {'size' : 'Size (Mb)'},
            productType: 'DVD',
            parameters: {
                'DVD' : {'size' : 'Size (Mb)'},
                'Book' : {'weight' : 'Weight (KG)'},
                'Furniture' : {
                    'height' : 'Height (CM)',
                    'width' : 'Width (CM)',
                    'length' : 'Length (CM)'
                },
            },
            description: {
                'DVD' : "Please, provide DVD's size in megabytes (MB). 1 GB = 1000 MB",
                'Book' : "Please, provide book's weight in kilograms (KG)",
                'Furniture' : "Please, provide dimensions in HxWxL format in centimetres",
            }
        }
    },
    methods: {
        onTypeChange(event){
            this.selected = this.parameters[this.productType]
        }
    },
    mounted: function() {
        this.productType = document.querySelector('#productType').getAttribute('data-selected');
        this.selected = this.parameters[this.productType];
    }
}).mount('#product_form');