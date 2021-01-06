import 'package:fluttermultigrocery/constant/ps_dimens.dart';
import 'package:fluttermultigrocery/ui/common/ps_ui_widget.dart';
import 'package:fluttermultigrocery/utils/utils.dart';
import 'package:fluttermultigrocery/viewobject/product_collection_header.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';

class CollectionHeaderListItem extends StatelessWidget {
  const CollectionHeaderListItem(
      {Key key,
      @required this.productCollectionHeader,
      @required this.onTap,
      this.animationController,
      this.animation})
      : super(key: key);

  final ProductCollectionHeader productCollectionHeader;
  final Function onTap;
  final AnimationController animationController;
  final Animation<double> animation;

  @override
  Widget build(BuildContext context) {
    animationController.forward();
    return AnimatedBuilder(
        animation: animationController,
        child: InkWell(
          onTap: () {
            onTap();
          },
          child: Container(
            margin: const EdgeInsets.all(PsDimens.space8),
            child: Column(
              mainAxisSize: MainAxisSize.max,
              children: <Widget>[
                ClipRRect(
                  borderRadius: BorderRadius.circular(PsDimens.space4),
                  child: PsNetworkImage(
                    photoKey: '',
                    defaultPhoto: productCollectionHeader.defaultPhoto,
                    width: MediaQuery.of(context).size.width,
                    height: PsDimens.space160,
                    boxfit: BoxFit.cover,
                    onTap: () {
                      Utils.psPrint(
                          productCollectionHeader.defaultPhoto.imgParentId);
                      onTap();
                    },
                  ),
                ),
                Padding(
                  padding: const EdgeInsets.all(8.0),
                  child: Text(productCollectionHeader.name,
                      textAlign: TextAlign.center,
                      style: Theme.of(context)
                          .textTheme
                          .subtitle1
                          .copyWith(fontSize: PsDimens.space16)),
                )
              ],
            ),
          ),
        ),
        builder: (BuildContext context, Widget child) {
          return FadeTransition(
            opacity: animation,
            child: Transform(
              transform: Matrix4.translationValues(
                  0.0, 100 * (1.0 - animation.value), 0.0),
              child: child,
            ),
          );
        });
  }
}
