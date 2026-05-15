<x-input type="hidden" name="id_table" :value="$id_table" />
<script>
				$(document).ready(function() {
								columns = window.LaravelDataTables[$("input[name=id_table]").val()].columns();
								toggleColumnsDatatable(columns);
				});
</script>
