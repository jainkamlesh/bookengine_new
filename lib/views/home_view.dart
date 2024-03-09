import 'package:flutter/material.dart';
import 'package:my_cold_food_app/views/icecream_view_one.dart';

class HomePage extends StatelessWidget {
  const HomePage({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
   debugShowCheckedModeBanner: false,
  theme: ThemeData(
    brightness: Brightness.light,
    primaryColor: Colors.amber,
  
    
    ),
  home:  const IcreamPage(),
);
  }
}