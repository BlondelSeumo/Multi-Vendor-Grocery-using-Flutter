import 'package:fluttermultigrocery/config/ps_colors.dart';
import 'package:fluttermultigrocery/constant/ps_dimens.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:fluttermultigrocery/utils/utils.dart';
import 'package:fluttermultigrocery/viewobject/shipping_area.dart';

class AreaListItem extends StatelessWidget {
  const AreaListItem(
      {Key key,
      @required this.area,
      this.onTap,
      this.animationController,
      this.animation})
      : super(key: key);

  final ShippingArea area;
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
          width: MediaQuery.of(context).size.width,
          color: PsColors.backgroundColor,
          height: PsDimens.space52,
          margin: const EdgeInsets.only(top: PsDimens.space4),
          child: Padding(
              padding: const EdgeInsets.all(PsDimens.space16),
              child: Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: <Widget>[
                  Row(
                    children: <Widget>[
                      Text(
                        area.areaName,
                        textAlign: TextAlign.start,
                        style: Theme.of(context)
                            .textTheme
                            .subtitle1
                            .copyWith(fontWeight: FontWeight.bold),
                      ),
                      Text(
                        '( ' +
                            Utils.getString(context, 'checkout1__area_price') +
                            ' )',
                        textAlign: TextAlign.start,
                        style: Theme.of(context).textTheme.subtitle1.copyWith(),
                      ),
                    ],
                  ),
                  if (area.price == null ||
                      area.price == '' ||
                      double.parse(area.price) == 0)
                    Text(
                      'Free',
                      textAlign: TextAlign.end,
                      style: Theme.of(context).textTheme.subtitle2.copyWith(),
                    )
                  else
                    Text(
                      area.currencySymbol + ' ' + area.price,
                      textAlign: TextAlign.end,
                      style: Theme.of(context)
                          .textTheme
                          .subtitle1
                          .copyWith(fontWeight: FontWeight.bold),
                    ),
                ],
              )),
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
