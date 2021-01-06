import 'package:easy_localization/easy_localization.dart';
import 'package:flutter/material.dart';
import 'package:flutter_datetime_picker/flutter_datetime_picker.dart';
import 'package:flutter_icons/flutter_icons.dart';
import 'package:fluttermultigrocery/api/common/ps_resource.dart';
import 'package:fluttermultigrocery/config/ps_colors.dart';
import 'package:fluttermultigrocery/config/ps_config.dart';
import 'package:fluttermultigrocery/constant/ps_constants.dart';
import 'package:fluttermultigrocery/constant/ps_dimens.dart';
import 'package:fluttermultigrocery/constant/route_paths.dart';
import 'package:fluttermultigrocery/provider/user/user_provider.dart';
import 'package:fluttermultigrocery/repository/user_repository.dart';
import 'package:fluttermultigrocery/ui/common/dialog/error_dialog.dart';
import 'package:fluttermultigrocery/ui/common/dialog/success_dialog.dart';
import 'package:fluttermultigrocery/ui/common/ps_button_widget.dart';
import 'package:fluttermultigrocery/ui/common/ps_dropdown_base_with_controller_widget.dart';
import 'package:fluttermultigrocery/ui/common/ps_textfield_widget.dart';
import 'package:fluttermultigrocery/ui/map/current_location_view.dart';
import 'package:fluttermultigrocery/utils/ps_progress_dialog.dart';
import 'package:fluttermultigrocery/utils/utils.dart';
import 'package:fluttermultigrocery/viewobject/common/ps_value_holder.dart';
import 'package:fluttermultigrocery/viewobject/holder/profile_update_view_holder.dart';
import 'package:fluttermultigrocery/viewobject/shipping_area.dart';
import 'package:fluttermultigrocery/viewobject/user.dart';
import 'package:latlong/latlong.dart';
import 'package:provider/provider.dart';
import 'package:flutter/services.dart';

class Checkout1View extends StatefulWidget {
  const Checkout1View(this.updateCheckout1ViewState);
  final Function updateCheckout1ViewState;

  @override
  _Checkout1ViewState createState() {
    final _Checkout1ViewState _state = _Checkout1ViewState();
    updateCheckout1ViewState(_state);
    return _state;
  }
}

class _Checkout1ViewState extends State<Checkout1View> {
  TextEditingController userEmailController = TextEditingController();
  TextEditingController userPhoneController = TextEditingController();
  TextEditingController addressController = TextEditingController();
  TextEditingController shippingAreaController = TextEditingController();
  TextEditingController orderTimeTextEditingController =
      TextEditingController();

  bool isSwitchOn = false;
  UserRepository userRepository;
  UserProvider userProvider;
  PsValueHolder valueHolder;

  // bool isClickDeliveryButton = true;
  // bool isClickPickUpButton = false;
  String deliveryPickUpDate;
  String deliveryPickUpTime;

  bool bindDataFirstTime = true;
  LatLng latlng;

  DateTime now = DateTime.now();
  DateTime dateTime =
      DateTime.now().add(const Duration(minutes: PsConfig.defaultOrderTime));
  String latestDate;

  dynamic updateDeliveryClick() {
    setState(() {});
    if (userProvider.isClickDeliveryButton) {
      userProvider.isClickDeliveryButton = false;
      userProvider.isClickPickUpButton = true;
    } else {
      userProvider.isClickDeliveryButton = true;
      userProvider.isClickPickUpButton = false;
    }
  }

  dynamic updatePickUpClick() {
    setState(() {});
    if (userProvider.isClickPickUpButton) {
      userProvider.isClickPickUpButton = false;
      userProvider.isClickDeliveryButton = true;
    } else {
      userProvider.isClickPickUpButton = true;
      userProvider.isClickDeliveryButton = false;
    }
  }

  dynamic updateOrderByData(String filterName) {
    setState(() {
      userProvider.selectedRadioBtnName = filterName;
    });
  }

  dynamic updatDateAndTime(DateTime dateTime) {
    setState(() {});
    latestDate = '$dateTime';
    deliveryPickUpDate = latestDate.split(' ')[0];
    deliveryPickUpTime = DateFormat.jm().format(DateTime.parse(latestDate));
    orderTimeTextEditingController.text =
        deliveryPickUpDate + ' ' + deliveryPickUpTime;
  }

  @override
  Widget build(BuildContext context) {
    userRepository = Provider.of<UserRepository>(context);
    valueHolder = Provider.of<PsValueHolder>(context);
    userProvider = Provider.of<UserProvider>(context, listen: false);
    if (userProvider.selectedRadioBtnName == PsConst.ORDER_TIME_ASAP) {
      updatDateAndTime(dateTime);
    }
    return Consumer<UserProvider>(builder:
        (BuildContext context, UserProvider userProvider, Widget child) {
      if (userProvider.user != null && userProvider.user.data != null) {
        if (bindDataFirstTime) {
          /// Shipping Data
          // userEmailController.text = userProvider.user.data.userEmail;
          // userPhoneController.text = userProvider.user.data.userPhone;
          // addressController.text = userProvider.user.data.address;
          // if (userProvider.user.data.area != null) {
          //   shippingAreaController.text = userProvider.user.data.area.areaName +
          //       ' (' +
          //       userProvider.user.data.area.currencySymbol +
          //       userProvider.user.data.area.price +
          //       ')';
          // }
          // userProvider.selectedArea = userProvider.user.data.area;
          // latlng = userProvider.getUserLatLng();
          // bindDataFirstTime = false;
          userEmailController.text = userProvider.user.data.userEmail;
          userPhoneController.text = userProvider.user.data.userPhone;
          addressController.text = userProvider.user.data.address;
          shippingAreaController.text = userProvider.user.data.area.areaName +
              ' (' +
              userProvider.user.data.area.currencySymbol +
              userProvider.user.data.area.price +
              ')';
          userProvider.selectedArea = userProvider.user.data.area;
          latlng = userProvider.getUserLatLng();
          bindDataFirstTime = false;
        }
        return SingleChildScrollView(
          child: Container(
            color: PsColors.coreBackgroundColor,
            padding: const EdgeInsets.only(
                left: PsDimens.space16, right: PsDimens.space16),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: <Widget>[
                const SizedBox(
                  height: PsDimens.space16,
                ),
                Container(
                  margin: const EdgeInsets.only(
                      left: PsDimens.space12,
                      right: PsDimens.space12,
                      top: PsDimens.space16),
                  child: Text(
                    Utils.getString(context, 'checkout1__contact_info'),
                    style: Theme.of(context).textTheme.subtitle2.copyWith(),
                  ),
                ),
                const SizedBox(
                  height: PsDimens.space16,
                ),
                PsTextFieldWidget(
                    titleText: Utils.getString(context, 'edit_profile__email'),
                    textAboutMe: false,
                    hintText: Utils.getString(context, 'edit_profile__email'),
                    textEditingController: userEmailController,
                    isMandatory: true),
                PsTextFieldWidget(
                    titleText: Utils.getString(context, 'edit_profile__phone'),
                    textAboutMe: false,
                    keyboardType: TextInputType.number,
                    hintText: Utils.getString(context, 'edit_profile__phone'),
                    textEditingController: userPhoneController,
                    isMandatory: true),
                RadioWidget(
                  userProvider: userProvider,
                  updateOrderByData: updateOrderByData,
                  orderTimeTextEditingController:
                      orderTimeTextEditingController,
                  updatDateAndTime: updatDateAndTime,
                  latestDate: latestDate,
                ),
                _EditAndDeleteButtonWidget(
                    userProvider: userProvider,
                    updateDeliveryClick: updateDeliveryClick,
                    updatePickUpClick: updatePickUpClick,
                    isClickDeliveryButton: userProvider.isClickDeliveryButton,
                    isClickPickUpButton: userProvider.isClickPickUpButton),
                const SizedBox(height: PsDimens.space8),
                if (userProvider.isClickDeliveryButton)
                  Column(
                    children: <Widget>[
                      CurrentLocationWidget(
                        androidFusedLocation: true,
                        textEditingController: addressController,
                      ),
                      Container(
                          width: double.infinity,
                          height: PsDimens.space120,
                          margin: const EdgeInsets.fromLTRB(PsDimens.space8, 0,
                              PsDimens.space8, PsDimens.space16),
                          decoration: BoxDecoration(
                            color: PsColors.backgroundColor,
                            borderRadius:
                                BorderRadius.circular(PsDimens.space4),
                            border:
                                Border.all(color: PsColors.mainDividerColor),
                          ),
                          child: TextField(
                              keyboardType: TextInputType.multiline,
                              maxLines: null,
                              controller: addressController,
                              style: Theme.of(context).textTheme.bodyText2,
                              decoration: InputDecoration(
                                contentPadding: const EdgeInsets.only(
                                  left: PsDimens.space12,
                                  bottom: PsDimens.space8,
                                  top: PsDimens.space10,
                                ),
                                border: InputBorder.none,
                                hintText: Utils.getString(
                                    context, 'edit_profile__address'),
                                hintStyle: Theme.of(context)
                                    .textTheme
                                    .bodyText2
                                    .copyWith(
                                        color: PsColors.textPrimaryLightColor),
                              ))),
                      PsDropdownBaseWithControllerWidget(
                          title: Utils.getString(context, 'checkout1__area'),
                          textEditingController: shippingAreaController,
                          isMandatory: true,
                          onTap: () async {
                            final dynamic result = await Navigator.pushNamed(
                                context, RoutePaths.areaList);

                            if (result != null && result is ShippingArea) {
                              setState(() {
                                shippingAreaController.text = result.areaName +
                                    ' (' +
                                    result.currencySymbol +
                                    ' ' +
                                    result.price +
                                    ')';
                                userProvider.selectedArea = result;
                              });
                            }
                          }),
                      const SizedBox(height: PsDimens.space16),
                    ],
                  )
                else
                  Container(),
              ],
            ),
          ),
        );
      } else {
        return Container();
      }
    });
  }

  dynamic checkIsDataChange(UserProvider userProvider) async {
    if (userProvider.user.data.userEmail == userEmailController.text &&
        userProvider.user.data.userPhone == userPhoneController.text &&
        userProvider.user.data.address == addressController.text &&
        userProvider.user.data.area.areaName == shippingAreaController.text &&
        userProvider.user.data.userLat == userProvider.originalUserLat &&
        userProvider.user.data.userLng == userProvider.originalUserLng) {
      return true;
    } else {
      return false;
    }
  }

  dynamic callUpdateUserProfile(UserProvider userProvider) async {
    bool isSuccess = false;

    if (userProvider.isClickPickUpButton) {
      userProvider.selectedArea.id = '';
      userProvider.selectedArea.price = '0.0';
      userProvider.selectedArea.areaName = '';
    }

    if (await Utils.checkInternetConnectivity()) {
      final ProfileUpdateParameterHolder profileUpdateParameterHolder =
          ProfileUpdateParameterHolder(
        userId: userProvider.psValueHolder.loginUserId,
        userName: userProvider.user.data.userName,
        userEmail: userEmailController.text,
        userPhone: userPhoneController.text,
        userAddress: addressController.text,
        userAboutMe: userProvider.user.data.userAboutMe,
        userAreaId: userProvider.selectedArea.id,
        userLat: userProvider.user.data.userLat,
        userLng: userProvider.user.data.userLng,
      );
      await PsProgressDialog.showDialog(context);
      final PsResource<User> _apiStatus = await userProvider
          .postProfileUpdate(profileUpdateParameterHolder.toMap());
      if (_apiStatus.data != null) {
        PsProgressDialog.dismissDialog();
        isSuccess = true;

        showDialog<dynamic>(
            context: context,
            builder: (BuildContext contet) {
              return SuccessDialog(
                message: Utils.getString(context, 'edit_profile__success'),
              );
            });
      } else {
        PsProgressDialog.dismissDialog();

        showDialog<dynamic>(
            context: context,
            builder: (BuildContext context) {
              return ErrorDialog(
                message: _apiStatus.message,
              );
            });
      }
    } else {
      showDialog<dynamic>(
          context: context,
          builder: (BuildContext context) {
            return ErrorDialog(
              message: Utils.getString(context, 'error_dialog__no_internet'),
            );
          });
    }

    return isSuccess;
  }
}

class RadioWidget extends StatefulWidget {
  const RadioWidget(
      {@required this.userProvider,
      @required this.updateOrderByData,
      @required this.orderTimeTextEditingController,
      @required this.updatDateAndTime,
      @required this.latestDate});
  final UserProvider userProvider;
  final Function updateOrderByData;
  final TextEditingController orderTimeTextEditingController;
  final Function updatDateAndTime;
  final String latestDate;

  @override
  _RadioWidgetState createState() => _RadioWidgetState();
}

class _RadioWidgetState extends State<RadioWidget> {
  @override
  Widget build(BuildContext context) {
    return Column(
      children: <Widget>[
        Container(
          margin: const EdgeInsets.only(
              left: PsDimens.space12,
              top: PsDimens.space12,
              right: PsDimens.space12),
          child: Row(
            children: <Widget>[
              Row(
                children: <Widget>[
                  Text(Utils.getString(context, 'checkout1__order_time'),
                      style: Theme.of(context).textTheme.bodyText1),
                  Text(' *',
                      style: Theme.of(context)
                          .textTheme
                          .bodyText1
                          .copyWith(color: PsColors.mainColor))
                ],
              )
            ],
          ),
        ),
        Column(
            mainAxisAlignment: MainAxisAlignment.spaceAround,
            children: <Widget>[
              Row(
                children: <Widget>[
                  Radio<String>(
                    value: widget.userProvider.selectedRadioBtnName,
                    groupValue: PsConst.ORDER_TIME_ASAP,
                    onChanged: (String name) {
                      widget.updateOrderByData(PsConst.ORDER_TIME_ASAP);
                      final DateTime dateTime = DateTime.now().add(
                          const Duration(minutes: PsConfig.defaultOrderTime));
                      widget.updatDateAndTime(dateTime);
                    },
                    materialTapTargetSize: MaterialTapTargetSize.shrinkWrap,
                    activeColor: PsColors.mainColor,
                  ),
                  Expanded(
                    child: Text(
                      Utils.getString(context, 'checkout1__asap') +
                          ' (' +
                          PsConfig.defaultOrderTime.toString() +
                          'mins)',
                      style: Theme.of(context).textTheme.bodyText1.copyWith(),
                      maxLines: 1,
                      overflow: TextOverflow.ellipsis,
                    ),
                  ),
                ],
              ),
              Row(
                children: <Widget>[
                  Radio<String>(
                    value: widget.userProvider.selectedRadioBtnName,
                    groupValue: PsConst.ORDER_TIME_SCHEDULE,
                    onChanged: (String name) async {
                      widget.updateOrderByData(PsConst.ORDER_TIME_SCHEDULE);

                      DatePicker.showDateTimePicker(context,
                          showTitleActions: true, onChanged: (DateTime date) {},
                          onConfirm: (DateTime date) {
                        final DateTime now = DateTime.now();
                        if (DateTime(date.year, date.month, date.day, date.hour,
                                    date.minute, date.second)
                                .difference(DateTime(now.year, now.month,
                                    now.day, now.hour, now.minute, now.second))
                                .inDays <
                            0) {
                          showDialog<dynamic>(
                              context: context,
                              builder: (BuildContext context) {
                                return ErrorDialog(
                                  message: Utils.getString(context,
                                      'chekcout1__past_date_time_error'),
                                );
                              });
                        } else {
                          print('confirm $date');
                          setState(() {});
                          widget.updatDateAndTime(date);
                        }
                      }, locale: LocaleType.en);
                    },
                    materialTapTargetSize: MaterialTapTargetSize.shrinkWrap,
                    activeColor: PsColors.mainColor,
                  ),
                  Expanded(
                    child: Text(
                      Utils.getString(context, 'checkout1__schedule'),
                      style: Theme.of(context).textTheme.bodyText1.copyWith(),
                      maxLines: 1,
                      overflow: TextOverflow.ellipsis,
                    ),
                  ),
                ],
              ),
            ]),
        Container(
            width: double.infinity,
            height: PsDimens.space44,
            margin: const EdgeInsets.all(PsDimens.space12),
            decoration: BoxDecoration(
              color: PsColors.backgroundColor,
              borderRadius: BorderRadius.circular(PsDimens.space4),
              border: Border.all(color: PsColors.mainDividerColor),
            ),
            child: TextField(
                enabled: widget.userProvider.selectedRadioBtnName ==
                    PsConst.ORDER_TIME_SCHEDULE,
                enableInteractiveSelection:
                    widget.userProvider.selectedRadioBtnName ==
                        PsConst.ORDER_TIME_SCHEDULE,
                keyboardType: TextInputType.text,
                maxLines: null,
                controller: widget.orderTimeTextEditingController,
                style: Theme.of(context).textTheme.bodyText2.copyWith(
                    color: widget.userProvider.selectedRadioBtnName ==
                            PsConst.ORDER_TIME_ASAP
                        ? PsColors.textPrimaryLightColor
                        : PsColors.textPrimaryColor),
                decoration: InputDecoration(
                  suffixIcon: GestureDetector(
                      onTap: () {
                        DatePicker.showDateTimePicker(context,
                            showTitleActions: true,
                            onChanged: (DateTime date) {},
                            onConfirm: (DateTime date) {
                          final DateTime now = DateTime.now();
                          if (DateTime(date.year, date.month, date.day,
                                      date.hour, date.minute, date.second)
                                  .difference(DateTime(
                                      now.year,
                                      now.month,
                                      now.day,
                                      now.hour,
                                      now.minute,
                                      now.second))
                                  .inDays <
                              0) {
                            showDialog<dynamic>(
                                context: context,
                                builder: (BuildContext context) {
                                  return ErrorDialog(
                                    message: Utils.getString(context,
                                        'chekcout1__past_date_time_error'),
                                  );
                                });
                          } else {
                            print('confirm $date');
                            widget.updatDateAndTime(date);
                          }
                        }, locale: LocaleType.en);
                      },
                      child: Icon(
                        AntDesign.calendar,
                        size: PsDimens.space20,
                        color: widget.userProvider.selectedRadioBtnName ==
                                PsConst.ORDER_TIME_ASAP
                            ? PsColors.textPrimaryLightColor
                            : PsColors.mainColor,
                      )),
                  contentPadding: const EdgeInsets.only(
                    top: PsDimens.space8,
                    left: PsDimens.space12,
                    bottom: PsDimens.space8,
                  ),
                  border: InputBorder.none,
                  hintText: '2020-10-2 3:00 PM',
                  hintStyle: Theme.of(context)
                      .textTheme
                      .bodyText2
                      .copyWith(color: PsColors.textPrimaryLightColor),
                ))),
      ],
    );
  }
}

class _EditAndDeleteButtonWidget extends StatefulWidget {
  const _EditAndDeleteButtonWidget(
      {Key key,
      @required this.userProvider,
      @required this.isClickPickUpButton,
      @required this.isClickDeliveryButton,
      @required this.updateDeliveryClick,
      @required this.updatePickUpClick})
      : super(key: key);

  final UserProvider userProvider;
  final bool isClickDeliveryButton;
  final bool isClickPickUpButton;
  final Function updateDeliveryClick;
  final Function updatePickUpClick;
  @override
  __EditAndDeleteButtonWidgetState createState() =>
      __EditAndDeleteButtonWidgetState();
}

class __EditAndDeleteButtonWidgetState
    extends State<_EditAndDeleteButtonWidget> {
  @override
  Widget build(BuildContext context) {
    return Container(
      alignment: Alignment.bottomCenter,
      child: Column(
        mainAxisSize: MainAxisSize.min,
        children: <Widget>[
          const SizedBox(height: PsDimens.space12),
          SizedBox(
            width: double.infinity,
            height: PsDimens.space40,
            child: Container(
              decoration: BoxDecoration(
                color: PsColors.backgroundColor,
                border: Border.all(color: PsColors.backgroundColor),
                borderRadius: const BorderRadius.only(
                    topLeft: Radius.circular(PsDimens.space12),
                    topRight: Radius.circular(PsDimens.space12)),
                boxShadow: <BoxShadow>[
                  BoxShadow(
                    color: PsColors.backgroundColor,
                    blurRadius: 10.0, // has the effect of softening the shadow
                    spreadRadius: 0, // has the effect of extending the shadow
                    offset: const Offset(
                      0.0, // horizontal, move right 10
                      0.0, // vertical, move down 10
                    ),
                  )
                ],
              ),
              child: Row(
                mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                children: <Widget>[
                  Expanded(
                    child: PSButtonWidget(
                      hasShadow: true,
                      hasShape: false,
                      textColor: widget.isClickDeliveryButton
                          ? PsColors.white
                          : PsColors.black,
                      width: double.infinity,
                      colorData: widget.isClickDeliveryButton
                          ? PsColors.mainColor
                          : PsColors.white,
                      titleText:
                          Utils.getString(context, 'checkout1__delivery'),
                      onPressed: () async {
                        widget.updateDeliveryClick();
                      },
                    ),
                  ),
                  const SizedBox(
                    width: PsDimens.space10,
                  ),
                  Expanded(
                    child: PSButtonWidget(
                      hasShadow: true,
                      hasShape: false,
                      width: double.infinity,
                      textColor: widget.isClickPickUpButton
                          ? PsColors.white
                          : PsColors.black,
                      colorData: widget.isClickPickUpButton
                          ? PsColors.mainColor
                          : PsColors.white,
                      titleText: Utils.getString(context, 'checkout1__pick_up'),
                      onPressed: () async {
                        widget.updatePickUpClick();
                      },
                    ),
                  ),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }
}
