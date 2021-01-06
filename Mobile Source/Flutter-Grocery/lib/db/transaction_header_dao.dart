import 'package:fluttermultigrocery/viewobject/transaction_header.dart';
import 'package:sembast/sembast.dart';
import 'package:fluttermultigrocery/db/common/ps_dao.dart' show PsDao;

class TransactionHeaderDao extends PsDao<TransactionHeader> {
  TransactionHeaderDao._() {
    init(TransactionHeader());
  }
  static const String STORE_NAME = 'TransactionHeader';
  final String _primaryKey = 'id';

  // Singleton instance
  static final TransactionHeaderDao _singleton = TransactionHeaderDao._();

  // Singleton accessor
  static TransactionHeaderDao get instance => _singleton;

  @override
  String getStoreName() {
    return STORE_NAME;
  }

  @override
  String getPrimaryKey(TransactionHeader object) {
    return object.id;
  }

  @override
  Filter getFilter(TransactionHeader object) {
    return Filter.equals(_primaryKey, object.id);
  }
}
