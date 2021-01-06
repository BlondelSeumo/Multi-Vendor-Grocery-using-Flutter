import 'package:fluttermultigrocery/config/ps_colors.dart';
import 'package:fluttermultigrocery/constant/ps_dimens.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:fluttermultigrocery/viewobject/customized_detail.dart';
import 'package:fluttermultigrocery/viewobject/product.dart';

class AttributeDetailListItem extends StatelessWidget {
  const AttributeDetailListItem(
      {Key key,
      @required this.attributeDetail,
      @required this.product,
      this.onTap,
      this.animationController,
      this.animation})
      : super(key: key);

  final CustomizedDetail attributeDetail;
  final Product product;
  final Function onTap;
  final AnimationController animationController;
  final Animation<double> animation;

  @override
  Widget build(BuildContext context) {
    animationController.forward();

    return AnimatedBuilder(
      animation: animationController,
      child: GestureDetector(
        onTap: onTap,
        child: Container(
          color: PsColors.backgroundColor,
          width: MediaQuery.of(context).size.width,
          margin: const EdgeInsets.only(top: PsDimens.space8),
          child: Padding(
            padding: const EdgeInsets.all(PsDimens.space16),
            child: Text(
              attributeDetail.name == ''
                  ? ''
                  : '${attributeDetail.name} [ +${product.currencySymbol}${attributeDetail.additionalPrice} ]',
              textAlign: TextAlign.start,
              style: Theme.of(context)
                  .textTheme
                  .subtitle1
                  .copyWith(fontWeight: FontWeight.bold),
            ),
          ),
        ),
      ),
      builder: (BuildContext contenxt, Widget child) {
        return FadeTransition(
          opacity: animation,
          child: Transform(
            transform: Matrix4.translationValues(
                0.0, 100 * (1.0 - animation.value), 0.0),
            child: child,
          ),
        );
      },
    );
  }
}
