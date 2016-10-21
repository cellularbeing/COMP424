import java.util.*;
//Ivan Chacon
//Projec1
class Testing {
	public static void main(String args[]){
      Scanner input = new Scanner(System.in);
      String myString = "DRPWPWXHDRDKDUBKIHQVQRIKPGWOVOESWPKPVOBBDVVVDXSURWRLUEBKOLVHIHBKHLHBLNDQRFLOQ";
      myString = myString.toUpperCase();
      char list[] = new char[myString.length()];
      
      for(int i = 0; i < myString.length(); i++){
         list[i] = myString.charAt(i);
      }
      
      printList(list);
      for(int i = 1; i < 26; i++){
         populate(list);
         printList(list);      
      }

		
	}
   
   public static void populate(char aList[]){
      for(int i = 0; i < aList.length; i++){
         if(aList[i] == 'Z'){
            aList[i] = 'A';
         }
         else
            aList[i]++;
      }
   }
   public static void printList(char aList[]){
      for(int i = 0; i < aList.length; i++){
         System.out.print(aList[i] + " ");
      }
      System.out.println("\n");
   }
}
