<?php
// 5.2 Viết hàm kiểm tra một chuỗi có đối xứng không
// Ví dụ:
// - abcba là chuỗi đối xứng
// - abcdba là chuỗi không đối xứng
    function kiem_tra_chuoi_palindrome($string)   
    {  
        echo 'Chuổi hiện tại: $string';
        echo 'Chuổi đảo: '. strrev($string);
        if ($string == strrev($string))  
        {
            echo 'Chuổi đối xứng';
            return 1;
                
        }
        else  
        {
            echo 'Chuổi ko đối xứng';
            return 0;
                
        }
    } 
    kiem_tra_chuoi_palindrome(1); 
?>