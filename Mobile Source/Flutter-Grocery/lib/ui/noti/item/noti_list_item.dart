import 'package:fluttermultigrocery/config/ps_colors.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:fluttermultigrocery/constant/ps_dimens.dart';
import 'package:fluttermultigrocery/ui/common/ps_ui_widget.dart';
import 'package:fluttermultigrocery/viewobject/noti.dart';

class NotiListItem extends StatelessWidget {
  const NotiListItem({
    Key key,
    @required this.noti,
    this.animationController,
    this.animation,
    this.onTap,
  }) : super(key: key);

  final Noti noti;
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
            margin: const EdgeInsets.only(top: PsDimens.space8),
            padding: const EdgeInsets.all(PsDimens.space16),
            child: Row(
              mainAxisSize: MainAxisSize.max,
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              crossAxisAlignment: CrossAxisAlignment.end,
              children: <Widget>[
                const SizedBox(
                  width: PsDimens.space4,
                ),
                Expanded(
                  child: Row(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: <Widget>[
                      Container(
                        width: PsDimens.space64,
                        height: PsDimens.space64,
                        child: PsNetworkImage(
                          photoKey: '',
                          defaultPhoto: noti.defaultPhoto,
                          // width: PsDimens.space64,
                          // height: PsDimens.space64,
                          onTap: onTap,
                        ),
                      ),
                      const SizedBox(
                        width: PsDimens.space12,
                      ),
                      Expanded(
                        child: Text(noti.message,
                            textAlign: TextAlign.start,
                            style: Theme.of(context)
                                .textTheme
                                .bodyText2
                                .copyWith(fontWeight: FontWeight.bold)),
                      ),
                    ],
                  ),
                ),
                Text(noti.addedDateStr,
                    maxLines: 2,
                    overflow: TextOverflow.ellipsis,
                    textAlign: TextAlign.right),
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
