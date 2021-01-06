import 'package:fluttermultigrocery/config/ps_colors.dart';
import 'package:fluttermultigrocery/constant/ps_dimens.dart';
import 'package:fluttermultigrocery/provider/product/search_product_provider.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

class SpecialCheckTextWidget extends StatefulWidget {
  const SpecialCheckTextWidget({
    Key key,
    @required this.title,
    @required this.icon,
    @required this.checkTitle,
    this.size = PsDimens.space20,
  }) : super(key: key);

  final String title;
  final IconData icon;
  final int checkTitle;
  final double size;

  @override
  _SpecialCheckTextWidgetState createState() => _SpecialCheckTextWidgetState();
}

class _SpecialCheckTextWidgetState extends State<SpecialCheckTextWidget> {
  @override
  Widget build(BuildContext context) {
    final SearchProductProvider provider =
        Provider.of<SearchProductProvider>(context);

    return Container(
        width: double.infinity,
        height: PsDimens.space52,
        child: Container(
          margin: const EdgeInsets.all(PsDimens.space12),
          child: Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: <Widget>[
              Row(
                children: <Widget>[
                  Container(
                      width: widget.size < PsDimens.space20
                          ? PsDimens.space20
                          : widget.size,
                      child: Icon(
                        widget.icon,
                        size: widget.size,
                      )),
                  const SizedBox(
                    width: PsDimens.space12,
                  ),
                  Text(
                    widget.title,
                    style: Theme.of(context).textTheme.bodyText2,
                  ),
                ],
              ),
              if (widget.checkTitle == 1)
                Switch(
                  value: provider.isSwitchedFeaturedProduct,
                  onChanged: (bool value) {
                    setState(() {
                      provider.isSwitchedFeaturedProduct = value;
                    });
                  },
                  activeTrackColor: PsColors.mainColor,
                  activeColor: PsColors.mainColor,
                )
              else if (widget.checkTitle == 2)
                Switch(
                  value: provider.isSwitchedDiscountPrice,
                  onChanged: (bool value) {
                    setState(() {
                      provider.isSwitchedDiscountPrice = value;
                    });
                  },
                  activeTrackColor: PsColors.mainColor,
                  activeColor: PsColors.mainColor,
                )
            ],
          ),
        ));
  }
}
