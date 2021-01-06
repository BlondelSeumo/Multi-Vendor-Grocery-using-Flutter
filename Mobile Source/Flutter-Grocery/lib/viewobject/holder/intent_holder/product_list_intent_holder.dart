import 'package:fluttermultigrocery/viewobject/holder/product_parameter_holder.dart';
import 'package:flutter/cupertino.dart';

class ProductListIntentHolder {
  const ProductListIntentHolder({
    @required this.productParameterHolder,
    @required this.appBarTitle,
  });
  final ProductParameterHolder productParameterHolder;
  final String appBarTitle;
}
