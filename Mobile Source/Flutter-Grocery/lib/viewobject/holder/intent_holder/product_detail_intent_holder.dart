import 'package:flutter/material.dart';
import 'package:fluttermultigrocery/viewobject/basket_selected_add_on.dart';

import '../../basket_selected_attribute.dart';
import '../../product.dart';

class ProductDetailIntentHolder {
  const ProductDetailIntentHolder(
      {@required this.product,
      this.id,
      this.qty,
      this.selectedColorId,
      this.selectedColorValue,
      this.basketPrice,
      this.basketSelectedAttributeList,
      this.basketSelectedAddOnList,
      this.heroTagImage,
      this.heroTagTitle,
      this.heroTagOriginalPrice,
      this.heroTagUnitPrice});

  final String id;
  final String basketPrice;
  final List<BasketSelectedAttribute> basketSelectedAttributeList;
  final List<BasketSelectedAddOn> basketSelectedAddOnList;
  final String selectedColorId;
  final String selectedColorValue;
  final Product product;
  final String qty;
  final String heroTagImage;
  final String heroTagTitle;
  final String heroTagOriginalPrice;
  final String heroTagUnitPrice;
}
