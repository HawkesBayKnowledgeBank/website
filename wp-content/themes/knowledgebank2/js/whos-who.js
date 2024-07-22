jQuery(function($){

    $('#whos-who thead tr').clone(true).addClass('filters').appendTo('#whos-who thead');
    console.log(people_json)

       var dt = $('#whos-who').DataTable({
           orderCellsTop: true,
           fixedHeader: true,
           initComplete: function () {
                       var api = this.api();

                       // For each column
                       api
                           .columns()
                           .eq(0)
                           .each(function (colIdx) {

                               // Set the header cell to contain the input element
                               var cell = $('.filters th').eq(
                                   $(api.column(colIdx).header()).index()
                               );

                               if(colIdx > 2) {
                                   $(cell).text('');
                                   return;
                               }

                               var title = $(cell).text();
                               $(cell).html('<span><input type="text" placeholder="Search ' + title + '" /><i class="mdi mdi-magnify"></i></span>');

                               // On every keypress in this input
                               $(
                                   'input',
                                   $('.filters th').eq($(api.column(colIdx).header()).index())
                               )
                                   .off('keyup change')
                                   .on('keyup change', function (e) {
                                       e.stopPropagation();

                                       // Get the search value
                                       $(this).attr('title', $(this).val());
                                       var regexr = '({search})'; //$(this).parents('th').find('select').val();

                                       var letter = $('input[name="letter"]:checked').val();

                                       var cursorPosition = this.selectionStart;
                                       // Search the column for that value

                                       //if the first letter of our search value is the same as 'letter' we can ignore 'letter'... I think...
                                       var searchvalue = this.value;
                                       var prefix = '';
                                       if(colIdx == 1){
                                           if(letter != '' && searchvalue.substring(0,1).toLowerCase() != letter.toLowerCase()){
                                               prefix = '^' + letter + '.+?';
                                           }
                                           else if(searchvalue != '' && letter != ''){
                                               prefix = '^';
                                           }
                                       }
                                       searchvalue = prefix + this.value;
                                       console.log('search ' + searchvalue)
                                       api
                                           .column(colIdx)
                                           .search(
                                               searchvalue != ''
                                                   ? regexr.replace('{search}', '(((' + searchvalue + ')))')
                                                   : '',
                                               searchvalue != '',
                                               searchvalue == ''
                                           )
                                           .draw();


                                   });
                           });
                   },
            // ajax: {
            //     url: "/wp-admin/admin-ajax.php?action=people_endpoint",
            //     cache:false,
            // },
            data: people_json.data,
            columns: [
                { data: 'id', "visible": false, },
                { data: 'lname' },
                { data: 'fname' },
                { data: 'dob' },
                { data: 'dod' },
            ],
            columnDefs: [ {
                "targets": [1,2],
                "data": "link",
                "render": function ( data, type, row, meta ) {
                  return '<a href="'+row.link+'" target="_blank" class="col' + meta.col + '">' + data  + '</a>';
                }
            } ],
            order: [[ 1, "asc" ],[ 2, "asc" ],[ 3, "asc" ]],
            pageLength: 100,
            lengthMenu: [[50, 100, 200, 500], [50, 100, 200, 500]],
            sDom: 'Rfrtlip',
            language: {
                lengthMenu: "Display _MENU_ per page",
                info: "Showing _START_ to _END_ of _TOTAL_"
            }
        }); //.DataTable()




        //Clicking letters

        $('.page-template-template-whos-who2 .control-option.alphabet label').click(function(){
            $('.page-template-template-whos-who2 .control-option.alphabet label').removeClass('active');
            $(this).addClass('active');

            const url = new URL(window.location);
            if($(this).find('input').val() != ''){
                var letter = $(this).find('input').val();
                url.searchParams.set('letter', letter);
            }
            else{
                url.searchParams.delete('letter');
            }
            window.history.pushState({}, '', url);

            filter_table();
        });

        $('.page-template-template-whos-who2 .control-option.alphabet select').change(function(){

            var val = $(this).val();
            $('.page-template-template-whos-who2 .control-option.alphabet input[name="letter"][value="' + val + '"]').click();

        });

        function filter_table(){

            //letter
            var letter = $('input[name="letter"]:checked').val();
            if(letter){
                dt.columns(1).search('^' + letter, true).draw();
            }
            else{
                dt.columns(1).search('').draw();
            }

            $('#whos-who .filters input').trigger('change');

        }//filter_table()
        filter_table();

});
