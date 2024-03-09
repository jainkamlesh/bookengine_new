import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class IcreamPage extends StatefulWidget {
  const IcreamPage({super.key});

  @override
  State<IcreamPage> createState() => _IcreamPageState();
}

class _IcreamPageState extends State<IcreamPage> {
  Future<String?> getData()  async{

    Future<String?> data;
    try {
       DefaultAssetBundle.of(context).loadString("assets/menu.json").then((value) {
        print(value.toString());
       });

          data =  DefaultAssetBundle.of(context).loadString("assets/menu.json");
         return data;
    } catch (e) {
      print('Error : $e');
      return null;
    }

  }

@override
  void initState() {
    super.initState();
    getData();
  }
  @override
  Widget build(BuildContext context) {
    return Scaffold(
    
    appBar: AppBar(
      backgroundColor: Colors.lime,
      title:Text("ICECREAMS",
      style: TextStyle(
        fontFamily: GoogleFonts.aclonica().fontFamily,
        
      ),)
      
    ),
    body: Padding(

      
      padding: const EdgeInsets.all(8.0),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text("We have something yummy for you",
          style: TextStyle(
          fontFamily: GoogleFonts.aclonica().fontFamily,
          ),),
           Expanded(child: Column(
              crossAxisAlignment: CrossAxisAlignment.center,
              mainAxisAlignment: MainAxisAlignment.center,
            
              children: [
                FutureBuilder(future: getData(),
                 builder: (context, snapshot) {
 
                   var data = jsonDecode(snapshot.data.toString());

                   if(data == null){

                    return const Center(
                      child: Text("Data is not available"));
                      }

                   else{

                      return  Center(
                        child: Text(data["title"][0] ));

                   }

                 
                   
                 },),
              ],

          ))
          
          ],),

          
    ),
  );
  }
}