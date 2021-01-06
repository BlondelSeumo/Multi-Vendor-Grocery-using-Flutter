import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter_icons/flutter_icons.dart';
import 'package:fluttermultigrocery/config/ps_colors.dart';
import 'package:fluttermultigrocery/constant/ps_constants.dart';
import 'package:fluttermultigrocery/constant/ps_dimens.dart';
import 'package:fluttermultigrocery/ui/common/ps_ui_widget.dart';
import 'package:fluttermultigrocery/ui/common/smooth_star_rating_widget.dart';
import 'package:fluttermultigrocery/utils/utils.dart';
import 'package:fluttermultigrocery/viewobject/shop.dart';

class ShopHorizontalListItem extends StatelessWidget {
  const ShopHorizontalListItem({
    Key key,
    @required this.shop,
    this.onTap,
  }) : super(key: key);

  final Shop shop;
  final Function onTap;

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
        onTap: onTap,
        child: Card(
          elevation: 0.0,
          color: PsColors.transparent,
          child: Container(
            height: 400,
            width: 300,
            margin: const EdgeInsets.all(PsDimens.space4),
            child: ClipPath(
              child: Column(
                mainAxisSize: MainAxisSize.min,
                crossAxisAlignment: CrossAxisAlignment.start,
                mainAxisAlignment: MainAxisAlignment.start,
                children: <Widget>[
                  Expanded(
                    child: PsNetworkImage(
                      photoKey: '',
                      defaultPhoto: shop.defaultPhoto,
                      width: MediaQuery.of(context).size.width,
                      height: double.infinity,
                      boxfit: BoxFit.cover,
                      onTap: () {
                        Utils.psPrint(shop.defaultPhoto.imgParentId);
                        onTap();
                      },
                    ),
                  ),
                  Padding(
                    padding: const EdgeInsets.all(PsDimens.space12),
                    child: Text(
                      shop.name,
                      overflow: TextOverflow.ellipsis,
                      style: Theme.of(context).textTheme.subtitle1,
                      maxLines: 1,
                    ),
                  ),
                  Container(
                      child: Padding(
                    padding: const EdgeInsets.only(
                        left: PsDimens.space12, right: PsDimens.space12),
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
                            style: Theme.of(context)
                                .textTheme
                                .bodyText1
                                .copyWith(),
                            maxLines: 1,
                          ),
                        ),
                      ],
                    ),
                  )),
                  Padding(
                    padding: const EdgeInsets.only(
                        left: PsDimens.space8,
                        top: PsDimens.space8,
                        bottom: PsDimens.space8,
                        right: PsDimens.space8),
                    child: Row(
                      mainAxisAlignment: MainAxisAlignment.spaceBetween,
                      children: <Widget>[
                        Row(
                          children: <Widget>[
                            SmoothStarRating(
                                key: Key(shop.ratingDetail.totalRatingValue),
                                rating: double.parse(
                                    shop.ratingDetail.totalRatingValue),
                                allowHalfRating: false,
                                onRated: (double v) {
                                  onTap();
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
              ),
              clipper: ShapeBorderClipper(
                  shape: RoundedRectangleBorder(
                      borderRadius: BorderRadius.circular(4))),
            ),
          ),
        ));
  }
}
