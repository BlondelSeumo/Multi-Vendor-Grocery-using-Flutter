import 'package:fluttermultigrocery/config/ps_colors.dart';
import 'package:fluttermultigrocery/constant/ps_dimens.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:fluttermultigrocery/ui/common/smooth_star_rating_widget.dart';
import 'package:fluttermultigrocery/viewobject/shop_rating.dart';

class CustomerReviewListItem extends StatelessWidget {
  const CustomerReviewListItem({
    Key key,
    @required this.shopRating,
    this.onTap,
  }) : super(key: key);

  final ShopRating shopRating;
  final Function onTap;

  @override
  Widget build(BuildContext context) {
    if (shopRating != null && shopRating.rating != null) {
      return GestureDetector(
        onTap: onTap,
        child: Container(
          color: PsColors.backgroundColor,
          margin: const EdgeInsets.only(
              top: PsDimens.space8,
              left: PsDimens.space16,
              right: PsDimens.space16),
          padding: const EdgeInsets.all(PsDimens.space16),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: <Widget>[
              SmoothStarRating(
                  key: Key(shopRating.rating),
                  rating: double.parse(shopRating.rating),
                  isReadOnly: true,
                  allowHalfRating: false,
                  starCount: 5,
                  size: PsDimens.space16,
                  color: PsColors.ratingColor,
                  borderColor: PsColors.grey.withAlpha(100),
                  spacing: 0.0),
              Padding(
                padding: const EdgeInsets.only(
                    top: PsDimens.space8, bottom: PsDimens.space8),
                child: Text(
                  shopRating.user.userName,
                  style: Theme.of(context).textTheme.bodyText2,
                ),
              ),
              Text(
                shopRating.description,
                style: Theme.of(context).textTheme.bodyText1,
              ),
            ],
          ),
        ),
      );
    } else {
      return Container();
    }
  }
}
