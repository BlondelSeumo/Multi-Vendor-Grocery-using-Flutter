import 'package:flutter/material.dart';
import 'package:fluttermultigrocery/config/ps_colors.dart';
import 'package:fluttertoast/fluttertoast.dart';

class PsToast {
  void showToast(String message,
      {Color backgroundColor,
      Color textColor,
      ToastGravity gravity = ToastGravity.BOTTOM,
      Toast length = Toast.LENGTH_SHORT}) {
    backgroundColor ??= PsColors.mainColor;
    textColor ??= PsColors.white;

    Fluttertoast.showToast(
        msg: message,
        toastLength: length,
        gravity: gravity,
        timeInSecForIosWeb: 1,
        backgroundColor: backgroundColor,
        textColor: textColor);
  }
}
