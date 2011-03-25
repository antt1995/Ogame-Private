// ������� �����.
#ifndef WIN32
#include <linux/types.h>
typedef __u64 u64;
#else
typedef unsigned __int64 u64;
#endif

typedef struct TechParam {
    long    structure;
    long    shield;
    long    attack;
    long    cargo;  // ������ ��� �����.
} TechParam;

// ������ �����.
typedef struct Slot
{
    unsigned    long fleet[14];         // ����
    unsigned    long def[8];            // �������
    int         weap, shld, armor;      // ����������
    int         g, s, p;                // ����������
    unsigned    char name[128];         // ��� ������
} Slot;

// ������ �����.
typedef struct Unit {
    unsigned char slot_id;
    unsigned char obj_type;
    unsigned char exploded;
    unsigned char dummy;                // ��� ������������ ��������� �� 4 �����.
    long    hull, hullmax;
    long    shield, shieldmax;
} Unit;

// ������ �� ������.
typedef struct RoundInfo {
    Unit        *aunits, *dunits;       // ������ ������ �� ����� ������
    int         aunum, dunum;
    u64         shoots[2], spower[2], absorbed[2]; // ����� ���������� �� ���������.    
    unsigned    long memload;
} RoundInfo;

// ��������� �����.
typedef struct BattleState {
    int         result;             // ��������� ���, ������ SPECSIM_BATTLE_*
    int         rounds;
    RoundInfo   round;
    u64         aloss, dloss;       // ������ ���������� � ��������������
    u64         dm, dk;             // ���� ��������
    u64         cm, ck, cd;         // ��������� �������, ���������, ��������
    int         moonchance;         // ���� ����������� ����
    // ���������� � ��������������� �������.
    unsigned long ExplodedDefense[8], ExplodedDefenseTotal;
    unsigned long RepairDefense[8], RepairDefenseTotal;
} BattleState;

extern TechParam fleetParam[14];
extern TechParam defenseParam[8];
