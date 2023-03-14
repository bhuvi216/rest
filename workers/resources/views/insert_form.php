<html>
   <head>
       <title> Employee Management| add </title>
</head>
<body>
   <form action ="/create" method ="post">
       <input type ="hidden" name ="_token" value ="<?php echo csrf_token();?>">
       <table>
           <tr>
               <td> name </td>
               <td> <input type ='text' name ='staff_name'/> </td>
</tr>
<tr>
               <td> department </td>
               <td> <input type ='text' department ='staff_department'/> </td>
</tr>

<td> mail id </td>
               <td> <input type ='text' mail id ='staff_department'/> </td>
<tr>
   <td colspan ='2' >
       <input type ='submit' value ="add "/>
</td>
</tr>
</table>
</form>
</body>
</html>
