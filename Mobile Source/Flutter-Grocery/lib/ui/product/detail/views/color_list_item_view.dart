import 'package:flutter/material.dart';
import 'package:fluttermultigrocery/config/ps_colors.dart';
import 'package:fluttermultigrocery/constant/ps_dimens.dart';
import 'package:fluttermultigrocery/viewobject/Item_color.dart';

class ColorListItemView extends StatelessWidget {
  const ColorListItemView({
    Key key,
    @required this.color,
    @required this.selectedColorId,
    this.onColorTap,
  }) : super(key: key);

  final ItemColor color;
  final Function onColorTap;
  final String selectedColorId;

  Color hexToColor(String code) {
    return Color(int.parse(code.substring(1, 7), radix: 16) + 0xFF000000);
  }

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
        onTap: onColorTap,
        child: Container(
          margin: const EdgeInsets.symmetric(
              horizontal: PsDimens.space2, vertical: PsDimens.space2),
          child: _CheckIsSelectedWidget(
            color: color.colorValue != ''
                ? hexToColor(color.colorValue)
                : PsColors.grey,
            isSelected: color.id == selectedColorId,
          ),
        ));
  }
}

class _CheckIsSelectedWidget extends StatefulWidget {
  const _CheckIsSelectedWidget({
    Key key,
    @required this.color,
    this.onColorTap,
    @required this.isSelected,
  }) : super(key: key);

  final Color color;
  final Function onColorTap;
  final bool isSelected;

  @override
  __CheckIsSelectedWidgetState createState() => __CheckIsSelectedWidgetState();
}

class __CheckIsSelectedWidgetState extends State<_CheckIsSelectedWidget> {
  @override
  Widget build(BuildContext context) {
    if (widget.isSelected) {
      return Stack(
        alignment: const Alignment(0.0, 0.0),
        children: <Widget>[
          Container(
            width: PsDimens.space40,
            height: PsDimens.space40,
            decoration: BoxDecoration(
              borderRadius: BorderRadius.circular(20),
              color: widget.color,
              border: Border.all(width: 1, color: PsColors.grey),
            ),
          ),
          Container(
            width: PsDimens.space24,
            height: PsDimens.space24,
            decoration: BoxDecoration(
              borderRadius: BorderRadius.circular(20),
              color: PsColors.black.withAlpha(100),
              border: Border.all(width: 1, color: PsColors.grey),
            ),
            child: Container(
              child: Icon(
                Icons.check,
                color: PsColors.white,
                size: PsDimens.space16,
              ),
            ),
          )
        ],
      );
    } else {
      return Stack(
        alignment: const Alignment(0.0, 0.0),
        children: <Widget>[
          Container(
            width: PsDimens.space40,
            height: PsDimens.space40,
            decoration: BoxDecoration(
              borderRadius: BorderRadius.circular(20),
              color: widget.color,
              border: Border.all(width: 1, color: PsColors.grey),
            ),
          ),
        ],
      );
    }
  }
}
