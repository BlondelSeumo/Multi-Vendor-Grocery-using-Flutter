import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:fluttermultigrocery/constant/ps_dimens.dart';
import 'package:fluttermultigrocery/ui/common/ps_ui_widget.dart';
import 'package:fluttermultigrocery/viewobject/category.dart';

class CategoryHorizontalListItem extends StatelessWidget {
  const CategoryHorizontalListItem({
    Key key,
    @required this.category,
    this.onTap,
  }) : super(key: key);

  final Category category;
  final Function onTap;

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
        onTap: onTap,
        child: Column(
          children: <Widget>[
            Container(
              margin: const EdgeInsets.symmetric(
                  horizontal: PsDimens.space8, vertical: PsDimens.space12),
              width: PsDimens.space72,
              child: Container(
                width: PsDimens.space68,
                height: PsDimens.space68,
                child: Center(
                  child: PsNetworkIconImageLittleRadius(
                    photoKey: '',
                    // defaultPhoto: category.defaultPhoto,
                    defaultIcon: category.defaultIcon,
                    // width: PsDimens.space68,
                    // height: PsDimens.space68,
                    boxfit: BoxFit.fitHeight,
                  ),
                ),
              ),
            ),
            const SizedBox(height: PsDimens.space8),
            Container(
              padding: const EdgeInsets.only(
                  left: PsDimens.space2, right: PsDimens.space2),
              child: Text(
                category.name,
                textAlign: TextAlign.center,
                style: Theme.of(context)
                    .textTheme
                    .bodyText2
                    .copyWith(fontWeight: FontWeight.bold),
                maxLines: 1,
                overflow: TextOverflow.ellipsis,
              ),
            ),
          ],
        ));
  }
}
