import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter_icons/flutter_icons.dart';
import 'package:fluttermultigrocery/config/ps_colors.dart';
import 'package:fluttermultigrocery/constant/ps_constants.dart';
import 'package:fluttermultigrocery/constant/ps_dimens.dart';
import 'package:fluttermultigrocery/ui/common/ps_ui_widget.dart';
import 'package:fluttermultigrocery/ui/common/smooth_star_rating_widget.dart';
import 'package:fluttermultigrocery/viewobject/shop.dart';
import 'package:fluttermultigrocery/utils/utils.dart';

class ShopVerticleListItem extends StatelessWidget {
  const ShopVerticleListItem(
      {Key key,
      @required this.shop,
      this.onTap,
      this.animationController,
      this.animation})
      : super(key: key);

  final Shop shop;
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
            child: Card(
              elevation: 0.0,
              color: PsColors.transparent,
              child: Container(
                  margin: const EdgeInsets.all(PsDimens.space8),
                  child: ShopVerticleListItemWidget(shop: shop)),
            )),
        builder: (BuildContext context, Widget child) {
          return FadeTransition(
              opacity: animation,
              child: Transform(
                transform: Matrix4.translationValues(
                    0.0, 100 * (1.0 - animation.value), 0.0),
                child: child,
              ));
        });
  }
}

class ShopVerticleListItemWidget extends StatelessWidget {
  const ShopVerticleListItemWidget({
    Key key,
    @required this.shop,
  }) : super(key: key);

  final Shop shop;

  @override
  Widget build(BuildContext context) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: <Widget>[
        ClipRRect(
          borderRadius: BorderRadius.circular(PsDimens.space4),
          child: PsNetworkImage(
            height: PsDimens.space200,
            width: double.infinity,
            photoKey: '',
            defaultPhoto: shop.defaultPhoto,
            boxfit: BoxFit.cover,
          ),
        ),
        Padding(
          padding: const EdgeInsets.only(
              left: PsDimens.space8,
              right: PsDimens.space8,
              top: PsDimens.space12),
          child: Text(
            shop.name,
            style: Theme.of(context)
                .textTheme
                .subtitle1
                .copyWith(fontWeight: FontWeight.bold),
          ),
        ),
        Container(
            child: Padding(
          padding: const EdgeInsets.only(
              top: PsDimens.space8,
              left: PsDimens.space12,
              right: PsDimens.space12),
          child: Row(
            children: <Widget>[
              Text(
                '\$',
                overflow: TextOverflow.ellipsis,
                style: Theme.of(context).textTheme.subtitle1.copyWith(
                    color: shop.priceLevel == PsConst.PRICE_LOW ||
                            shop.priceLevel == PsConst.PRICE_MEDIUM ||
                            shop.priceLevel == PsConst.PRICE_HIGH
                        ? PsColors.mainColor
                        : PsColors.grey),
                maxLines: 2,
              ),
              Text(
                '\$',
                overflow: TextOverflow.ellipsis,
                style: Theme.of(context).textTheme.subtitle1.copyWith(
                    color: shop.priceLevel == PsConst.PRICE_MEDIUM ||
                            shop.priceLevel == PsConst.PRICE_HIGH
                        ? PsColors.mainColor
                        : PsColors.grey),
                maxLines: 2,
              ),
              Text(
                '\$',
                overflow: TextOverflow.ellipsis,
                style: Theme.of(context).textTheme.subtitle1.copyWith(
                    color: shop.priceLevel == PsConst.PRICE_HIGH
                        ? PsColors.mainColor
                        : PsColors.grey),
                maxLines: 2,
              ),
              const SizedBox(width: PsDimens.space8),
              Expanded(
                child: Text(
                  Utils.getString(context, 'shop_open') +
                      ' ${shop.openingHour} ' +
                      '-' +
                      ' ' +
                      Utils.getString(context, 'shop_close') +
                      '${shop.closingHour}',
                  overflow: TextOverflow.ellipsis,
                  style: Theme.of(context).textTheme.bodyText1.copyWith(),
                  maxLines: 1,
                ),
              ),
            ],
          ),
        )),
        Padding(
          padding: const EdgeInsets.only(
              top: PsDimens.space8,
              bottom: PsDimens.space12,
              left: PsDimens.space8,
              right: PsDimens.space8),
          child: Text(
            shop.description,
            maxLines: 4,
            style: Theme.of(context).textTheme.bodyText1.copyWith(height: 1.4),
          ),
        ),
        Padding(
          padding: const EdgeInsets.only(
              left: PsDimens.space8,
              bottom: PsDimens.space8,
              right: PsDimens.space8),
          child: Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: <Widget>[
              Row(
                children: <Widget>[
                  SmoothStarRating(
                      key: Key(shop.ratingDetail.totalRatingValue),
                      rating: double.parse(shop.ratingDetail.totalRatingValue),
                      allowHalfRating: false,
                      onRated: (double v) {
                        // onTap();
                      },
                      starCount: 5,
                      size: 20.0,
                      color: PsColors.ratingColor,
                      borderColor: PsColors.grey.withAlpha(100),
                      spacing: 0.0),
                  Text('  ( ${shop.ratingDetail.totalRatingCount} )',
                      // '${Utils.getString(context, 'feature_slider__rating')}',
                      textAlign: TextAlign.start,
                      style: Theme.of(context).textTheme.caption),
                ],
              ),
              Container(
                child: Icon(MaterialIcons.directions,
                    size: 32, color: PsColors.mainColor),
              ),
            ],
          ),
        ),
      ],
    );
  }
}
