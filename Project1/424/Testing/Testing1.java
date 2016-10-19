import java.util.*;
import java.io.*;

class Testing1 {
   static String myString = "BEHAPPYFORTHEMOMENTTHISMOMENTISYOURLIFEBYKHAYYAMOHANDALSOTHISCLASSISREALLYFUN";
   static char list[] = new char[myString.length()];
   static String txtPWD = System.getProperty("user.dir").toString();
   
	public static void main(String args[]){
      //place original string into an array
      for(int i = 0; i < myString.length(); i++){
         list[i] = myString.charAt(i);
      }
      for(int i = 0; i <= 25; i++){
         shift(i);
         if(dictionaryComparator(listToString()) > 4){
            System.out.println("\n" + listToString());
            System.out.println("contains: " + dictionaryComparator(listToString()) + " matches.");
            System.out.println("-------------------------------------------------------------------------------");
         }
         
      }      
   }//main 
   
   public static void shift(int n){
      if(n > 0){
         myString = "";
         for(int i = 0; i < list.length; i++){
            if(list[i] == 'Z'){
               list[i] = 'A';
            }
            else
               list[i]++;
         }
         for(int j = 0; j < list.length; j++){
            myString += list[j];
         }
      }        
   }   
   public static String listToString(){
      String str = "";
      for(int i = 0; i < list.length; i++){
         str += list[i];
      }
      return str;
   }
   
   public static int dictionaryComparator(String myStr){
		//input from txt file
      int count = 0;
	   BufferedReader theReader = null;
	   try {
			String currentLine;
			theReader = new BufferedReader(new FileReader(txtPWD + "/dictionary1.txt")); 
			while ((currentLine = theReader.readLine()) != null) { //read each line 
            currentLine = currentLine.toUpperCase();
            if(myStr.contains(currentLine) && currentLine.length() > 0){
               count++;
            }
			}//while 
			theReader.close();
	   } 
	   catch(FileNotFoundException e) {
         System.out.println("file not found.");                
      }
	   catch (IOException e) {
		   System.out.println("Error reading file.");
	   }	
      return count;
   }//fileRead     
   
}//class 