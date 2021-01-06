import 'package:fluttermultigrocery/config/ps_colors.dart';
import 'package:fluttermultigrocery/constant/ps_dimens.dart';
import 'package:flutter/material.dart';

class NutrientHorizontalListItem extends StatelessWidget {
  const NutrientHorizontalListItem({
    Key key,
    @required this.nutrientName,
    @required this.onTap,
  }) : super(key: key);

  final String nutrientName;
  final Function onTap;
  @override
  Widget build(BuildContext context) {
    return nutrientName == ''
        ? Container()
        : GestureDetector(
            onTap: () {
              onTap();
            },
            child: Card(
              elevation: 0,
              shape: BeveledRectangleBorder(
                  side: BorderSide(color: PsColors.mainColor),
                  borderRadius: const BorderRadius.all(Radius.circular(7.0))),
              child: Container(
                margin: const EdgeInsets.all(PsDimens.space4),
                padding: const EdgeInsets.only(
                    left: PsDimens.space8, right: PsDimens.space8),
                child: Center(
                  child: Text(
                    nutrientName,
                    style: Theme.of(context)
                        .textTheme
                        .bodyText2
                        .copyWith(color: PsColors.mainColor),
                  ),
                ),
              ),
            ),
          );
  }
}
