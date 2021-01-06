import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:fluttermultigrocery/config/ps_colors.dart';
import 'package:fluttermultigrocery/constant/ps_dimens.dart';
import 'package:fluttermultigrocery/ui/common/ps_ui_widget.dart';

import 'package:fluttermultigrocery/viewobject/category.dart';

class CategoryHorizontalTrendingListItem extends StatelessWidget {
  const CategoryHorizontalTrendingListItem(
      {Key key,
      @required this.category,
      this.onTap,
      @required this.animationController,
      @required this.animation})
      : super(key: key);

  final Category category;

  final Function onTap;
  final AnimationController animationController;
  final Animation<double> animation;

  @override
  Widget build(BuildContext context) {
    return AnimatedBuilder(
        animation: animationController,
        child: GestureDetector(
            onTap: onTap,
            child: Container(
                margin: const EdgeInsets.symmetric(
                    horizontal: PsDimens.space8, vertical: PsDimens.space8),
                decoration: BoxDecoration(
                  color: PsColors.backgroundColor,
                  borderRadius:
                      const BorderRadius.all(Radius.circular(PsDimens.space8)),
                ),
                child: Stack(
                  alignment: Alignment.center,
                  children: <Widget>[
                    ClipRRect(
                      borderRadius: BorderRadius.circular(4),
                      child: Stack(
                        children: <Widget>[
                          Container(
                            width: PsDimens.space200,
                            height: double.infinity,
                            child: PsNetworkImage(
                                photoKey: '',
                                defaultPhoto: category.defaultPhoto,
                                // width: PsDimens.space200,
                                // height: double.infinity,
                                boxfit: BoxFit.cover,
                                onTap: onTap),
                          ),
                          Container(
                              width: 200,
                              height: double.infinity,
                              color: PsColors.black.withAlpha(110)),
                        ],
                      ),
                    ),
                    Padding(
                        padding: const EdgeInsets.all(PsDimens.space8),
                        child: Text(
                          category.name,
                          textAlign: TextAlign.start,
                          style: Theme.of(context).textTheme.subtitle1.copyWith(
                              color: PsColors.white,
                              fontWeight: FontWeight.bold),
                          maxLines: 2,
                          overflow: TextOverflow.ellipsis,
                        )),
                    Container(
                        child: Positioned(
                      bottom: 10,
                      left: 10,
                      child: PsNetworkCircleIconImage(
                          photoKey: '',
                          defaultIcon: category.defaultIcon,
                          width: PsDimens.space40,
                          height: PsDimens.space40,
                          boxfit: BoxFit.cover,
                          onTap: onTap),
                    )),
                  ],
                ))),
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

class CustomPolygon extends CustomPainter {
  CustomPolygon(this._topWidth, this._bottomWidth, this._height, this._color);

  final double _topWidth;
  final double _bottomWidth;
  final double _height;
  final Color _color;

  @override
  void paint(Canvas canvas, Size size) {
    final Path path = Path();

    path.addPolygon(<Offset>[
      Offset.zero,
      Offset(_topWidth, 0),
      Offset(_bottomWidth, _height),
      Offset(0, _height),
    ], true);

    path.arcToPoint(
      const Offset(10, 10),
      radius: const Radius.circular(30),
    );

    final Paint paint = Paint();
    paint.color = _color;
    paint.style = PaintingStyle.fill;
    canvas.drawPath(path, paint);
  }

  @override
  bool shouldRepaint(CustomPolygon oldDelegate) {
    return false;
  }
}
