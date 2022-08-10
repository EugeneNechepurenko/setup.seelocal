<?php

function encrypts ($str) // ~0.0020s for 40symbols
{

    // define base info
    $key='megakey'; //key
    $dic = '1234567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; //symbols from which will be creating our list of characters
    $dict[0]=$dic; // set first string line of list

    // START creating list of characters

    $t = ''; //temp variable

    //strlen($dic) = its a length of $dic, so array will have same length as length of $dic
    //we already set zero in array so start loop from 1st, that`s why "length - 1"
    for ($d=1; $d<=strlen($dic)-1; $d++) // starting loop of creating list
    {


        for ($x=0; $x<=strlen($dic); $x++) // start loop of creating array of element from which will have line in list
        {
            $dict_l=strlen($dic); // get length of our symbols

            //for 1st element in line, get last element to first place
            if(isset($dict[$d - 1][$dict_l])) { //check for availability symbol in the previous array element, for example $dict[0][12] = A
                $tmp[0] = $dict[$d - 1][$dict_l]; // adding to temp. variable symbol from $dict
            }


            //for other elements in line
            if($x>0)
            {
                // set all other element without 1st and last element
                if(isset($dict[$d-1][$x])) { //check for availability symbol in the previous array element, for example $dict[0][12] = A
                    $tmp[$x] = $dict[$d - 1][$x]; // adding to temp. variable symbol from $dict
                }
                //send first element from prev. array element to last position in new array element
                $tmp[$dict_l]=$dict[$d-1][0]; // adding to temp. variable symbol from $dict
            }
        }
        /* Example 1 (list in c#)
        after first loop will have this in 	$tmp, the first element to to the end
        Array
        (
            [1] => 2
            [64] => 1
            [2] => 3
            [3] => 4
            [4] => 5
            [5] => 6
            [6] => 7
            [7] => 8
            [8] => 9
            [9] => 0
            [10] => =
            [11] => @
            [12] => A
            [13] => B
            [14] => C
            [15] => D
            [16] => E
            [17] => F
            [18] => G
            [19] => H
            [20] => I
            [21] => J
            [22] => K
            [23] => L
            [24] => M
            [25] => N
            [26] => O
            [27] => P
            [28] => Q
            [29] => R
            [30] => S
            [31] => T
            [32] => U
            [33] => V
            [34] => W
            [35] => X
            [36] => Y
            [37] => Z
            [38] => a
            [39] => b
            [40] => c
            [41] => d
            [42] => e
            [43] => f
            [44] => g
            [45] => h
            [46] => i
            [47] => j
            [48] => k
            [49] => l
            [50] => m
            [51] => n
            [52] => o
            [53] => p
            [54] => q
            [55] => r
            [56] => s
            [57] => t
            [58] => u
            [59] => v
            [60] => w
            [61] => x
            [62] => y
            [63] => z
        )
        */


        for ($i=0; $i<=strlen($dic); $i++) // start loop for creating string line from array
        {
            if(isset($tmp[$i])) { // check the element for not empty value, so if element empty will skip
                $t .= $tmp[$i]; // adding character from not empty elements from array to string line
            }
        }
        // after loop will have "234567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1" in $t

        $dict[$d]=$t; // add $t to new element to array (list)
        $t=""; // remove created string for creating next string
    }
    /*
    // END creating list of characters


        After loop $dict will have this list of string lines

    Array     Example 1 (list in c#)
    (
        [0] => 1234567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz
        [1] => 234567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1
        [2] => 34567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz12
        [3] => 4567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123
        [4] => 567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234
        [5] => 67890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz12345
        [6] => 7890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456
        [7] => 890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567
        [8] => 90=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz12345678
        [9] => 0=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789
        [10] => =@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890
        [11] => @ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890=
        [12] => ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890=@
        [13] => BCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890=@A
        [14] => CDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890=@AB
        [15] => DEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890=@ABC
        [16] => EFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890=@ABCD
        [17] => FGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890=@ABCDE
        [18] => GHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890=@ABCDEF
        [19] => HIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890=@ABCDEFG
        [20] => IJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890=@ABCDEFGH
        [21] => JKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890=@ABCDEFGHI
        [22] => KLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890=@ABCDEFGHIJ
        [23] => LMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890=@ABCDEFGHIJK
        [24] => MNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890=@ABCDEFGHIJKL
        [25] => NOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890=@ABCDEFGHIJKLM
        [26] => OPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890=@ABCDEFGHIJKLMN
        [27] => PQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890=@ABCDEFGHIJKLMNO
        [28] => QRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890=@ABCDEFGHIJKLMNOP
        [29] => RSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890=@ABCDEFGHIJKLMNOPQ
        [30] => STUVWXYZabcdefghijklmnopqrstuvwxyz1234567890=@ABCDEFGHIJKLMNOPQR
        [31] => TUVWXYZabcdefghijklmnopqrstuvwxyz1234567890=@ABCDEFGHIJKLMNOPQRS
        [32] => UVWXYZabcdefghijklmnopqrstuvwxyz1234567890=@ABCDEFGHIJKLMNOPQRST
        [33] => VWXYZabcdefghijklmnopqrstuvwxyz1234567890=@ABCDEFGHIJKLMNOPQRSTU
        [34] => WXYZabcdefghijklmnopqrstuvwxyz1234567890=@ABCDEFGHIJKLMNOPQRSTUV
        [35] => XYZabcdefghijklmnopqrstuvwxyz1234567890=@ABCDEFGHIJKLMNOPQRSTUVW
        [36] => YZabcdefghijklmnopqrstuvwxyz1234567890=@ABCDEFGHIJKLMNOPQRSTUVWX
        [37] => Zabcdefghijklmnopqrstuvwxyz1234567890=@ABCDEFGHIJKLMNOPQRSTUVWXY
        [38] => abcdefghijklmnopqrstuvwxyz1234567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZ
        [39] => bcdefghijklmnopqrstuvwxyz1234567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZa
        [40] => cdefghijklmnopqrstuvwxyz1234567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZab
        [41] => defghijklmnopqrstuvwxyz1234567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabc
        [42] => efghijklmnopqrstuvwxyz1234567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcd
        [43] => fghijklmnopqrstuvwxyz1234567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcde
        [44] => ghijklmnopqrstuvwxyz1234567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdef
        [45] => hijklmnopqrstuvwxyz1234567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefg
        [46] => ijklmnopqrstuvwxyz1234567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefgh
        [47] => jklmnopqrstuvwxyz1234567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghi
        [48] => klmnopqrstuvwxyz1234567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghij
        [49] => lmnopqrstuvwxyz1234567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijk
        [50] => mnopqrstuvwxyz1234567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkl
        [51] => nopqrstuvwxyz1234567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklm
        [52] => opqrstuvwxyz1234567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmn
        [53] => pqrstuvwxyz1234567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmno
        [54] => qrstuvwxyz1234567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnop
        [55] => rstuvwxyz1234567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopq
        [56] => stuvwxyz1234567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqr
        [57] => tuvwxyz1234567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrs
        [58] => uvwxyz1234567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrst
        [59] => vwxyz1234567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstu
        [60] => wxyz1234567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuv
        [61] => xyz1234567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvw
        [62] => yz1234567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwx
        [63] => z1234567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxy
    )
    */
    // $dict have list of dictionaries http://joxi.ru/zAN4w5YidLQBm9
    // $dict[0] have our string

    // creating list of symbols from key with length of our string
    $j=0; // set temp. variable
    $k1 = array();// array for list of symbols
    for ($i=0; $i<=strlen($str)-1; $i++) //start loop of creating list of symbols from length of our string
    {
        $k1[$i] = $key[$j]; // get symbol from key, for example 1st symbol from key is "m", so
        $j=$j+1; // add 1 for get next symbol
        if($j==strlen($key)) // if it is last symbol in key, strlen($key) will give length of key, for example, $j = 7 and length (of string) of key is 7, so we set $j = 0
        {
            $j=0; // set 0 for start getting symbols from key from start (from 1st symbol)
        }
    }
    /*
    $k1 have list of symbols from key and length of our string
    Array
    Array
(
    [0] => m
    [1] => e
    [2] => g
    [3] => a
    [4] => k
    [5] => e
    [6] => y
    [7] => m
    [8] => e
    [9] => g
    [10] => a
    [11] => k
    [12] => e
    [13] => y
    [14] => m
    [15] => e
    [16] => g
    [17] => a
    [18] => k
    [19] => e
    [20] => y
    [21] => m
    [22] => e
    [23] => g
    [24] => a
    [25] => k
    [26] => e
    [27] => y
    [28] => m
    [29] => e
    [30] => g
    [31] => a
    [32] => k
    [33] => e
    [34] => y
    [35] => m
    [36] => e
    [37] => g
    [38] => a
    [39] => k
)

    */

    $k0=$str; // set $k1 = our string
    $crypt_word = ''; // define string variable for encrypt word
    for ($i=0; $i<=count($k1)-1; $i++) // start encrypting loop
    {
        // 1) our crypt word - ZEdWemRESkFkR1Z6ZEM1MFpYTno6TVRFeE1URXg=
        // 2) our key - mega_keymega_keymega_key..
        // 3) our zero element in list of dictionaries - 1234567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz
        // 4) 50th element in list of dictionaries - mnopqrstuvwxyz1234567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkl
        $s1=$k0[$i]; // $i=0, so get zero element from 1), it is Z
        $s2=$k1[$i]; // $i=0, so get zero element from 2), it is m
        $p_s1 = strpos($dict[0], $s1); // get position of symbol $s1 from 3), it is 37
        $p_s2 = strpos($dict[0], $s2); // get position of symbol $s2 from 3), it is 50

        $crypt_word .= $dict[$p_s2][$p_s1];// get 37th character from 50th element in our list of dictionaries, it is L AND add $crypt_word
    }
    return $crypt_word; // return done string veriable with encrypted word
}


function decrypts ($crypt) // ~0.0020s for 40symbols
{
    $key='megakey';
    $dic = '1234567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $dict[0]=$dic;
    $t = '';

    //loop the same as in crypt function
    for ($d=1; $d<=strlen($dic)-1; $d++) //creating list of dictionaries
    {
        for ($x=0; $x<=strlen($dic); $x++)
        {
            $dict_l=strlen($dic);
            if(isset($dict[$d - 1][$dict_l])) {
                $tmp[0] = $dict[$d - 1][$dict_l];
            }
            if($x>0)
            {
                if(isset($dict[$d-1][$x])) {
                    $tmp[$x] = $dict[$d - 1][$x];
                }
                $tmp[$dict_l]=$dict[$d-1][0];
            }
        }
        for ($i=0; $i<=strlen($dic); $i++)
        {
            if(isset($tmp[$i])) {
                $t .= $tmp[$i];
            }
        }
        $dict[$d]=$t;
        $t="";
    }
    // $dict have list of dictionaries

    //loop the same as in crypt function
    $j=0;
    $k1 = array();
    for ($i=0; $i<=strlen($crypt)-1; $i++)
    {
        $k1[$i] = $key[$j];
        $j=$j+1;
        if($j==strlen($key))
        {
            $j=0;
        }
    }


    $k0=$crypt;
    $decrypt_word = '';
    for ($i=0; $i<=count($k1)-1; $i++)
    {
        // 1) our string for decrypting LuJ9OQP39QrU8yLjFq9eK4TE6XS4F@0rOuyG8DGu
        // 2) our key - mega_keymega_keymega_key..
        // 3) our zero element in list of dictionaries - 1234567890=@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz
        // 4) 37th element in list of dictionaries - Zabcdefghijklmnopqrstuvwxyz1234567890=@ABCDEFGHIJKLMNOPQRSTUVWXY
        $s1=$k0[$i]; // $i=0, so get zero element from 1), it is L
        $s2=$k1[$i]; // $i=0, so get zero element from 2), it is m
        $p_s2 = strpos($dict[0], $s2); // get position of symbol $s2 from 3), it is 50
        $num_s = strpos($dict[$p_s2], $s1); // get position of symbol $s1 from element, number which we get in $p_s2, it is 37
        $decrypt_word .=  $dict[0][$num_s]; // get symbol from zero element from list, number which is 37, which we get in $num_s, it is Z
    }
    return $decrypt_word; //return decrypted word
}

$login = 'test2@test.tess'; //user login
$pass = '111111'; // user password

// creating string for encrypting
$login_b64 = base64_encode($login); //encode to base64 for hide symbols
$pass_b64 = base64_encode($pass); //encode to base64 for hide symbols
$login_pass_together = base64_encode( $login_b64.':'.$pass_b64 ); //make one line of login and password with separator and again encode to base64 for make one line of base64
$crypt = encrypts($login_pass_together); // encrypt encoded line

// creating string for decrypting
$decrypting = decrypts($crypt); // decrypt encrypted line
$get_from_b64 = base64_decode($decrypting); // decode from base64 for get line with separated login and password in base64
$explode_to_arr = explode(':',$get_from_b64); // get password and login from separated line
$get_login = base64_decode($explode_to_arr[0]); // get login from base64
$get_pass = base64_decode($explode_to_arr[1]); // get password from base64

//demonstration
echo 'login = '.$login;
echo '<br>';
echo 'pass = '.$pass;
echo '<br>';
echo 'login_b64 = '.$login_b64;
echo '<br>';
echo 'pass_b64 = '.$pass_b64;
echo '<br>';
echo 'login_pass_together = '.$login_pass_together;
echo '<br>';
echo 'crypt = '.$crypt;
echo '<br>';
echo '<br>';
echo '<br>';
echo 'login = '.$get_login;
echo '<br>';
echo 'pass = '.$get_pass;
echo '<br>';




/*
Briefing



We have login and password, which we need to hide and get back, for this good to use some cipher, anybody know caesar cipher,
some of use know vigenere and gronfeld cipher. Vigenere have letters vertically and horizontally, gronfeld have letters and digitals.
My code based on both cipher.

there is our string for encrypt and decrypt, some key for search in square (list of dictionaries) and also square (list)

our string for encrypt is "cbd" and key is "ca"

1) for start we set base symbols, it is string line like "abcd"

2) we create square

so here is square ("list of lines")

0 abcd
1 bcda
2 cdab
3 dabc

for zero line we set our base string line, and then copy to next line with move position each symbol with step "-1"

3) now copy each symbol from key for get string line of key symbols with length of encrypt word

now key will "cac"



now we can encrypt


key = cac
word = cbd


1 get position of first symbol of key in zero line, it is 2 (from 0,1,2) key1 = 2
2 get position of first symbol of word in zero line, it is 2 , word1 = 2

number of element in list is key1, so we use "cdab", and position of symbol is word1, it is "c"

then get position of second symbol in zero line with the same logic and etc


-------------
base 64 use for hide some symbols and get limit of symbols
here is string line which have characters of two languages, symbols and one icon

qweйцу321322---16¶4(^$#&*Q^$#*293576358nfsfhcnwfr

cXdl0LnRhtGDMzIxMzIyLS0tMTbCtjQoXiQjJipRXiQjKjI5MzU3NjM1OG5mc2ZoY253ZnI=

now we have small, big symbols, numbers and "="

*/


/*
----Example 1 - list in C#----------------------------------------------

code:

//Compiler version 4.0.30319.17929 for Microsoft (R) .NET Framework 4.5
using System;
using System.Collections.Generic;
namespace Rextester
{
    public class Program
    {
        public static void Main(string[] args)
        {
            string[] input = { "abcd", "bcda", "cdab" };
            List<string> list = new List<string>(input);
            Console.WriteLine("\n[0] {0}", list[0]);
            Console.WriteLine("\n[1] {0}", list[1]);
            Console.WriteLine("\n[2] {0}", list[2]);
        }
    }
}


Result:

[0] abcd
[1] bcda
[2] cdab
*/