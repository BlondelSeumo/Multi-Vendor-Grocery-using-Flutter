import 'package:quiver/core.dart';
import 'common/ps_object.dart';

class BasketSelectedAddOn extends PsObject<BasketSelectedAddOn> {
  BasketSelectedAddOn({this.id, this.name, this.price, this.currencySymbol});

  String id;
  String name;
  String currencySymbol;
  String price;

  final List<BasketSelectedAddOn> _selectedAddOnList = <BasketSelectedAddOn>[];

  List<BasketSelectedAddOn> getSelectedAddOnList() {
    return _selectedAddOnList;
  }

  // String getSelectedaddOnNameByHeaderId(
  //     String id, String headerName) {
  //   String name = 'Choose $headerName';
  //   for (BasketSelectedAddOn addOn in _selectedAddOnList) {
  //     if (id == addOn.id) {
  //       name = addOn.name +
  //           ' [ +' +
  //           addOn.currencySymbol +
  //           addOn.price +
  //           ' ] ';
  //       break;
  //     }
  //   }

  //   return name;
  // }

  bool isAlladdOnSelected(int totaladdOnLength) {
    if (_selectedAddOnList.length == totaladdOnLength) {
      return true;
    } else {
      return false;
    }
  }

  double getTotalSelectedaddOnPrice() {
    double totaladdOnPrice = 0.0;
    for (BasketSelectedAddOn addOn in _selectedAddOnList) {
      if (addOn.price != '') {
        totaladdOnPrice += double.parse(addOn.price);
      }
    }
    return totaladdOnPrice;
  }

  double getTotalSelectedaddOnPriceAndSubtract(String price) {
    double totaladdOnPrice = 0.0;
    for (BasketSelectedAddOn addOn in _selectedAddOnList) {
      if (addOn.price != '') {
        totaladdOnPrice += double.parse(addOn.price);
      }
    }
    if (price != '') {
      totaladdOnPrice -= double.parse(price);
    }
    return totaladdOnPrice;
  }

  String getSelectedaddOnIdByHeaderId() {
    String id = '';
    for (BasketSelectedAddOn addOn in _selectedAddOnList) {
      if (addOn.id != null) {
        id = id + '${addOn.id}';
      }
    }

    return id;
  }

  void addAddOn(BasketSelectedAddOn basketSelectedaddOn) {
    if (_selectedAddOnList.isEmpty) {
      _selectedAddOnList.add(basketSelectedaddOn);
    } else {
      bool isNew = true;
      int index = -1;

      // Checking based on the id
      for (int i = 0; i < _selectedAddOnList.length; i++) {
        if (_selectedAddOnList[i].id == basketSelectedaddOn.id) {
          isNew = false;
          index = i;
          break;
        }
      }

      // If new, add directly to list
      if (isNew) {
        _selectedAddOnList.add(basketSelectedaddOn);
      } else {
        // If existing id, replace it.
        _selectedAddOnList[index] = basketSelectedaddOn;
      }
    }
  }

  void subAddOn(BasketSelectedAddOn basketSelectedaddOn) {
    if (_selectedAddOnList.isNotEmpty) {
      _selectedAddOnList.remove(basketSelectedaddOn);
    }
  }

  @override
  bool operator ==(dynamic other) =>
      other is BasketSelectedAddOn && id == other.id;

  @override
  int get hashCode => hash2(id.hashCode, id.hashCode);

  @override
  String getPrimaryKey() {
    return id;
  }

  @override
  BasketSelectedAddOn fromMap(dynamic dynamicData) {
    if (dynamicData != null) {
      return BasketSelectedAddOn(
        id: dynamicData['id'],
        name: dynamicData['name'],
        price: dynamicData['price'],
        currencySymbol: dynamicData['currency_symbol'],
      );
    } else {
      return null;
    }
  }

  @override
  Map<String, dynamic> toMap(dynamic object) {
    if (object != null) {
      final Map<String, dynamic> data = <String, dynamic>{};
      data['id'] = object.id;
      data['name'] = object.name;
      data['price'] = object.price;
      data['currency_symbol'] = object.currencySymbol;
      return data;
    } else {
      return null;
    }
  }

  @override
  List<BasketSelectedAddOn> fromMapList(List<dynamic> dynamicDataList) {
    final List<BasketSelectedAddOn> userLoginList = <BasketSelectedAddOn>[];

    if (dynamicDataList != null) {
      for (dynamic dynamicData in dynamicDataList) {
        if (dynamicData != null) {
          userLoginList.add(fromMap(dynamicData));
        }
      }
    }
    return userLoginList;
  }

  @override
  List<Map<String, dynamic>> toMapList(List<dynamic> objectList) {
    final List<Map<String, dynamic>> dynamicList = <Map<String, dynamic>>[];
    if (objectList != null) {
      for (dynamic data in objectList) {
        if (data != null) {
          dynamicList.add(toMap(data));
        }
      }
    }
    return dynamicList;
  }
}
