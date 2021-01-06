import 'package:flutter/material.dart';

class PsSquareProgressWidget extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Container( 
      width : 25, 
      height : 25,       
      child: const LinearProgressIndicator(
        valueColor: AlwaysStoppedAnimation<Color>(Colors.black26),
        backgroundColor: Colors.black12    
      ),
    );
  }
}