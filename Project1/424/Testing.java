   import java.util.*;
   import java.io.*;

   class Testing {
   
      static int row =-1;
      static int col = -1;
		static int padded = -1;
		static int startPerm = 2;
		static int endPerm = 7;
		
		static int maxWordCount = 15;
		
      static String txtPWD = System.getProperty("user.dir").toString();
      static char matrix[][];
      static int nOrder[];
   	//static String myString = "tcamehatisetecx";
   	//static String myString = "RHAVTNUSREDEAIERIKATSOQR";
      static String myString = "DRPWPWXHDRDKDUBKIHQVQRIKPGWOVOESWPKPVOBBDVVVDXSURWRLUEBKOLVHIHBKHLHBLNDQRFLOQ";
      static char list[] = new char[myString.length()];
      static PrintWriter writer;
   
      public static void main(String args[]){
         myString = myString.toUpperCase();
         for(int i = 0; i < myString.length(); i++){
            list[i] = myString.charAt(i);
         }
			
         try {
            writer = new PrintWriter("output.txt", "UTF-8");
         } 
         catch(FileNotFoundException e) {
      		System.out.println("file not found.");                
      	}
         catch (IOException e) {
				System.out.println("Error reading file.");
         }			
			final long start = System.nanoTime();
			
			for(int n = startPerm; n <= endPerm; n++){
				
				//Calculate rows/col/matrix size-------------------------------------
				col = n;
				row = (int) Math.ceil((double)myString.length()/col);
				padded = (col - ((row*col) - myString.length())) - 1;
				/*System.out.println("col: " +col);
				System.out.println("row: " +row);
				System.out.println("padded: " +padded);
				System.out.println();*/
				//System.out.println(padded);
				//System.out.println(row);
				matrix = new char[row][col];
	      	//---------------------------------------------------
				for(int i = 0; i <= 25; i++){
	            shift(i);
					fileRead();			
	         }
			
			}  

			final long end = System.nanoTime();
			System.out.println("\nTotal time elapsed: " + (((end - start) / 1000000)/1000) + " seconds");
			 
			writer.println("\nTotal time elapsed: " + (((end - start) / 1000000)/1000) + " seconds");    
			writer.close();
			
			System.out.println("\nFor more information, see the 'output.txt' file.");    
           
      }//main 
      public static void matrixPopulate(){
         int k = 0;
      
         for(int i = 0; i < col; i++){
            int n = findIndex(nOrder, i);
				//System.out.println(n);
				if(n <= padded){
		         for(int j = 0; j < row; j++){
						//System.out.println("row: " +row + " col: " + col);
		         	matrix[j][n] = myString.charAt(k);
						//System.out.println("A:: j: " + j + "; n: " + n + "; k: " + k + " char: " + myString.charAt(k));
						//System.out.println(matrix[j][n]);
		         	k++;
					}				
				}
				else{
		         for(int j = 0; j < row-1; j++){
						//System.out.println("row: " +row + " col: " + col);
		         	matrix[j][n] = myString.charAt(k);
						//System.out.println("B:: j: " + j + "; n: " + n + "; k: " + k + " char: " + myString.charAt(k));
						//System.out.println(matrix[j][n]);
		         	k++;
					}
				}
         }     
      }
      public static int findIndex(int list[], int n){
         int theIndex = -1;
         for(int i = 0; i < list.length; i++){
            if(list[i] == n){
               theIndex = i;
               break;
            }
         }
         return theIndex;
      }//findIndex  
   
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
      }//shift
      public static void printList(char aList[]){
         for(int i = 0; i < aList.length; i++){
            System.out.print(aList[i] + " ");
         }
         System.out.println("\n");
      }//printList
   
      public static void printMatrix(){
         System.out.println();
         for(int i = 0; i < row; i++){
            for(int j = 0; j < col; j++){
               System.out.print(matrix[i][j] + " ");
            }
         }
      }//printMatrix 
      public static String matrixToString(){
         String str = "";
         for(int i = 0; i < row; i++){
            for(int j = 0; j < col; j++){
               str += matrix[i][j];
            }
         }
         return str;
      }//matrixToString 
	   public static String listToString(){
	      String str = "";
	      for(int i = 0; i < list.length; i++){
	         str += list[i];
	      }
	      return str;
	   }//listToString   
      public static void fileRead(){
      //input from txt file
         BufferedReader theReader = null;
         try {
            String currentLine;
            theReader = new BufferedReader(new FileReader(txtPWD + "/permutations/" + col + ".txt"));
            while ((currentLine = theReader.readLine()) != null) { //read each line 
					//System.out.println(currentLine);
               String temp[] = currentLine.split(",");
					nOrder = new int [temp.length];
               for(int j = 0; j < temp.length; j++){			
                  nOrder[j] = Integer.parseInt(temp[j]);
               }
               matrixPopulate();
					//System.out.println(matrixToString());
					if(dictionaryComparator(matrixToString(), false) >= maxWordCount){
	            	System.out.println("\n" + matrixToString());
	            	System.out.println("contains: " + dictionaryComparator(matrixToString(), false) + " matches.");
						System.out.println("Found during permutation: " + col);
	            	System.out.println("-------------------------------------------------------------------------------");
	            	writer.println("\n" + matrixToString());
	            	writer.println("\ncontains: " + dictionaryComparator(matrixToString(), true) + " matches.");
						writer.println("Found during permutation: " + col);
	            	writer.println("-------------------------------------------------------------------------------");						
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
		}//fileRead   
	   public static int dictionaryComparator(String myStr, boolean print){
			//input from txt file
	      int count = 0;
		   BufferedReader theReader = null;
		   try {
				String currentLine;
				theReader = new BufferedReader(new FileReader(txtPWD + "/dictionary1.txt")); 
				while ((currentLine = theReader.readLine()) != null) { //read each line 
	            currentLine = currentLine.toUpperCase();
	            if(myStr.contains(currentLine) && currentLine.length() > 0){
						if(print){
							writer.println(currentLine);
						}
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
	   }//dictionaryComparator 		
}//class