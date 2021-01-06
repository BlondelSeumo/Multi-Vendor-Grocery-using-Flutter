import 'package:flutter/material.dart';

class PayStackCreditCardWidget extends StatefulWidget {
  const PayStackCreditCardWidget({
    @required this.cardNumber,
    @required this.expiryDate,
    @required this.cardHolderName,
    @required this.cvvCode,
  });

  final String cardNumber;
  final String expiryDate;
  final String cardHolderName;
  final String cvvCode;

  @override
  _PayStackCreditCardWidgetState createState() =>
      _PayStackCreditCardWidgetState();
}

class _PayStackCreditCardWidgetState extends State<PayStackCreditCardWidget> {
  @override
  Widget build(BuildContext context) {
    return SingleChildScrollView(
      child: Container(
        margin: const EdgeInsets.all(16),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.spaceAround,
          crossAxisAlignment: CrossAxisAlignment.start,
          children: <Widget>[
            _CardNumberWidget(
              userCardNumberString: widget.cardNumber,
            ),
            _ExperiedDateWidget(
              userExperiedDateString: widget.expiryDate,
            ),
            _CCVWidget(
              userCCVString: widget.cvvCode,
            ),
            _CardHolderNameWidget(
              userHolderNameString: widget.cardHolderName,
            ),
          ],
        ),
      ),
    );
  }
}

class _CardNumberWidget extends StatefulWidget {
  const _CardNumberWidget({this.userCardNumberString});
  final String userCardNumberString;
  @override
  _CardNumberWidgetState createState() => _CardNumberWidgetState();
}

class _CardNumberWidgetState extends State<_CardNumberWidget> {
  @override
  Widget build(BuildContext context) {
    print('*****' + widget.userCardNumberString);
    return Column(
      children: <Widget>[
        Text(widget.userCardNumberString
            // titleText: 'Card Number',
            // hintText: 'XXXX XXXX XXXX XXXX XX',
            // textEditingController: widget.userCardNumberString
            ),
      ],
    );
  }
}

class _ExperiedDateWidget extends StatefulWidget {
  const _ExperiedDateWidget({this.userExperiedDateString});
  final String userExperiedDateString;
  @override
  _ExperiedDateWidgetState createState() => _ExperiedDateWidgetState();
}

class _ExperiedDateWidgetState extends State<_ExperiedDateWidget> {
  @override
  Widget build(BuildContext context) {
    print('*****' + widget.userExperiedDateString);
    return Column(
      children: <Widget>[
        // PsTextFieldWidget(
        //     titleText: 'Experied Date',
        //     hintText: 'MM/YY',
        //     textEditingController: widget.userExperiedDateString),
        Text(widget.userExperiedDateString),
      ],
    );
  }
}

class _CCVWidget extends StatefulWidget {
  const _CCVWidget({this.userCCVString});
  final String userCCVString;
  @override
  _CCVWidgetState createState() => _CCVWidgetState();
}

class _CCVWidgetState extends State<_CCVWidget> {
  @override
  Widget build(BuildContext context) {
    print('*****' + widget.userCCVString);
    return Column(
      children: <Widget>[
        // PsTextFieldWidget(
        //     titleText: 'CCV',
        //     hintText: 'XXX',
        //     textEditingController: widget.userCCVString),
        Text(widget.userCCVString),
      ],
    );
  }
}

class _CardHolderNameWidget extends StatefulWidget {
  const _CardHolderNameWidget({this.userHolderNameString});
  final String userHolderNameString;
  @override
  _CardHolderNameWidgetState createState() => _CardHolderNameWidgetState();
}

class _CardHolderNameWidgetState extends State<_CardHolderNameWidget> {
  @override
  Widget build(BuildContext context) {
    print('*****' + widget.userHolderNameString);
    return Column(
      children: <Widget>[
        // PsTextFieldWidget(
        //     titleText: 'Card Holder Name',
        //     hintText: 'Card Holder Name',
        //     textEditingController: widget.userHolderNameString),
        Text(widget.userHolderNameString),
      ],
    );
  }
}
