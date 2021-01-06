import 'package:quiver/core.dart';
import 'common/ps_object.dart';

class BasketSelectedAttribute extends PsObject<BasketSelectedAttribute> {
  BasketSelectedAttribute(
      {this.id, this.headerId, this.name, this.price, this.currencySymbol});

  String id;
  String headerId;
  String name;
  String currencySymbol;
  String price;

  final List<BasketSelectedAttribute> _selectedAttributeList =
      <BasketSelectedAttribute>[];

  List<BasketSelectedAttribute> getSelectedAttributeList() {
    return _selectedAttributeList;
  }

  String getSelectedAttributeNameByHeaderId(
      String headerId, String headerName) {
    String name = 'Choose $headerName';
    for (BasketSelectedAttribute attribute in _selectedAttributeList) {
      if (headerId == attribute.headerId) {
        name = attribute.name +
            ' [ +' +
            attribute.currencySymbol +
            attribute.price +
            ' ] ';
        break;
      }
    }

    return name;
  }

  bool isAllAttributeSelected(int totalAttributeLength) {
    if (_selectedAttributeList.length == totalAttributeLength) {
      return true;
    } else {
      return false;
    }
  }

  double getTotalSelectedAttributePrice() {
    double totalAttributePrice = 0.0;
    for (BasketSelectedAttribute attribute in _selectedAttributeList) {
      if (attribute.price != '') {
        if (attribute.price == null || attribute.price == '') {
          totalAttributePrice += 0.0;
        } else {
          totalAttributePrice += double.parse(attribute.price);
        }
      }
    }
    return totalAttributePrice;
  }

  String getSelectedAttributeIdByHeaderId() {
    String id = '';
    for (BasketSelectedAttribute attribute in _selectedAttributeList) {
      id = id + '${attribute.id}';
    }

    return id;
  }

  void addAttribute(BasketSelectedAttribute basketSelectedAttribute) {
    if (_selectedAttributeList.isEmpty) {
      _selectedAttributeList.add(basketSelectedAttribute);
    } else {
      bool isNew = true;
      int index = -1;

      // Checking based on the id
      for (int i = 0; i < _selectedAttributeList.length; i++) {
        if (_selectedAttributeList[i].headerId ==
            basketSelectedAttribute.headerId) {
          isNew = false;
          index = i;
          break;
        }
      }

      // If new, add directly to list
      if (isNew) {
        _selectedAttributeList.add(basketSelectedAttribute);
      } else {
        // If existing id, replace it.
        _selectedAttributeList[index] = basketSelectedAttribute;
      }
    }
  }

  @override
  bool operator ==(dynamic other) =>
      other is BasketSelectedAttribute && id == other.id;

  @override
  int get hashCode => hash2(id.hashCode, id.hashCode);

  @override
  String getPrimaryKey() {
    return id;
  }

  @override
  BasketSelectedAttribute fromMap(dynamic dynamicData) {
    if (dynamicData != null) {
      return BasketSelectedAttribute(
        id: dynamicData['id'],
        headerId: dynamicData['header_id'],
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
      data['header_id'] = object.headerId;
      data['name'] = object.name;
      data['price'] = object.price;
      data['currency_symbol'] = object.currencySymbol;
      return data;
    } else {
      return null;
    }
  }

  @override
  List<BasketSelectedAttribute> fromMapList(List<dynamic> dynamicDataList) {
    final List<BasketSelectedAttribute> userLoginList =
        <BasketSelectedAttribute>[];

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
